<?php
class Router{
	private static $data;
    private static $viewfunc;
    private static $action404;
    private static $url;
    private static $post;

	public static function addRoute($arr){
		if(empty($arr['route']) or empty($arr['action'])){
			return false;
		}
        if($arr['route'][0] != '/') $arr['route'] = '/' . $arr['route'];
		self::$data[$arr['route']] = $arr['action'];
		return true;
	}

    public static function _404($action){
        self::$action404 = $action;
        return false;
    }

    public static function ParseURLModRewrite()
    {
        $url = explode('/',$_SERVER['REQUEST_URI']);

        $count = count($url);

        for($i=1;$i<$count;$i++){
            if(empty($url[$i])){
                unset($url[$i]);
                continue;
            }
            $_GET[$url[$i]] = NULL;
        }

        self::$url = $_SERVER['REQUEST_URI'];
        $len = strlen(self::$url);
        if(self::$url[$len - 1] == '/' and $len > 1){
            self::$url = substr(self::$url,0,$len - 1);
        }

        return false;

    }

    public static function getUrl(){
        return self::$url;
    }

    private static function compareUrl($url,$route){
        $url = explode('/',$url);
        $route = explode('/',$route);
        $count = count($url);
        if($count != count($route))
            return false;
        for($i=0;$i<$count;$i++){
            if($url[$i] != $route[$i] and $route[$i] != '*' and !(strstr($route[$i],'{') and strstr($route[$i],'}'))){
                return false;
            }
        }
        return true;
    }

    private static function compareAll(){
        $count = count(self::$data);
        $keys = @array_keys(self::$data);
        for($i=0;$i<$count;$i++){
            if(self::compareUrl(self::$url,$keys[$i])){
                self::$url = $keys[$i];
                Request::setUrlTemp($keys[$i]);
                return true;
            }
        }
        return false;
    }

    private static function setUrl(){

        if(!self::$url){
            $keys = array_keys($_GET);
            $count = count($keys);

            for($i=0;$i<$count;$i++){
                if(empty($keys[$i]) and $i) continue;
                $url .= '/' . $keys[$i];
            }
            self::$url = $url;
        }

    }


    private static function routing($view){

        self::setUrl();

        if(isset(self::$data[self::$url]) or self::compareAll()){
            $url = self::$url;
            $f_name = self::$data[$url];

            
            if(is_object($f_name) or !strstr($f_name,'@')){
                if(!$view)
                    self::callFunc($f_name);
                else
                    $view(self::callFunc($f_name));
                return true;
            }
            
            $arr = explode('@',$f_name);
            
            if(!$view){
                self::call($arr[0], $arr[1]);
            }else
                $view(self::call($arr[0], $arr[1]));
            

        }else{  // action404
            
            $f_name = self::$action404;
            
            $ev_params = [
                'uri' => $_SERVER['REQUEST_URI'],
                'method' => 'get'
            ];
            
            if(strstr($f_name,'@')){
                $action_404 = explode('@', $f_name);
                $ev_params = array_merge($ev_params, [
                    'controllerName' => $action_404[0],
                    'actionName' => $action_404[1]
                ]);
            }else{
                $ev_params = array_merge($ev_params, [
                    'actionName' => $f_name
                ]);
            }
            
            Events::register('call_action_404', $ev_params);

            if(!strstr($f_name,'@')){
                if(!$view){
                    $f_name();
                }else{
                    $r = $f_name();
                    $view($r);
                }
                return true;
            }
            
            if(!$view){
                call_user_func(array($action_404[0], $action_404[1]));
            }else{
                $r = call_user_func(array($action_404[0], $action_404[1]));
                $view($r);
            }

        }

		return true;
    }
    
    public static function call($classname, $methname){
        
        $reflectionMethod = new ReflectionMethod($classname, $methname);

        $methParams = $reflectionMethod -> getParameters();

        $params = [];

        $count = count($methParams);

        $data = Request::getArgs();

        for($i=0;$i<$count;$i++){

            if(isset($data[$methParams[$i] -> name])){

                $params[] = $data[$methParams[$i] -> name];

            }

        }
        
        Events::register('call_action', [
            
            'controllerName' => $classname,
            'actionName' => $methname,
            'params' => is_array($params) ? $params : NULL,
            'method' => 'get'
            
        ]);
        
        return $reflectionMethod -> invokeArgs(new $classname(), $params);
        
    }
    
    public static function callFunc($funcname){

        $reflectionFunction = new ReflectionFunction($funcname);

        $funcParams = $reflectionFunction -> getParameters();

        $params = [];

        $count = count($funcParams);

        $data = Request::getArgs();

        for($i=0;$i<$count;$i++){

            if(isset($data[$funcParams[$i] -> name])){

                $params[] = $data[$funcParams[$i] -> name];

            }

        }
        
        Events::register('call_action', [

            'actionName' => $funcname,
            'params' => count($params) ? $params : NULL,
            'method' => 'get'

        ]);

        return $reflectionFunction -> invokeArgs($params);

    }

    public static function post($post,$action,$get = false){
        if(!$post or !$action) return false;

        if($get)
            self::$post[$post.':'.$get]['action'] = $action;
        else
            self::$post[$post]['action'] = $action;

        return true;
    }

    public static function eventsPost(){
        self::setUrl();

        $data = Request::post();
        $keys = array_keys($data);
        $count = count($data);
        for($i=0;$i<$count;$i++){
            if(isset(self::$post[$keys[$i]]) or isset(self::$post[$keys[$i].':'.self::$url])){

                $func = (isset(self::$post[$keys[$i]])) ? self::$post[$keys[$i]] : self::$post[$keys[$i].':'.self::$url];

                if(!isset($func['get']) or self::$url == $func['get']){
                    if(is_object($func['action']) or !strstr($func['action'],'@')){
                        
                        Events::register('call_action', [

                            'actionName' => $func['action'],
                            'params' => $data,
                            'method' => 'post'

                        ]);
                        
                        $func['action']();
                    }else{
                        $arr = explode('@',$func['action']);
                        
                        Events::register('call_action', [

                            'controllerName' => $arr[0],
                            'actionName' => $arr[1],
                            'params' => $data,
                            'method' => 'post'

                        ]);
                        
                        call_user_func(array($arr[0],$arr[1]));
                    }
                }
            }
        }
        return true;
    }

	public static function run($view = false){
        self::ParseURLModRewrite();
        if(!$view and self::$viewfunc){
            $view = self::$viewfunc;
        }elseif($view and !self::$viewfunc){
            self::$viewfunc = $view;
        }
        Request::clearGet();

        self::eventsPost();
		self::routing($view);

		return true;
	}

	public static function delRoute($route){
		if(empty($route)){
			return false;
		}
		if(isset(self::$data[$route])){
			unset(self::$data[$route]);
			return true;
		}
		return false;
	}

	public static function count_routes(){
		return count(self::$data);
	}

    public static function get($route,$action){
        self::addRoute(array('route'=>$route,'action'=>$action));
    }
    
    public static function linkTo($actionName, $params = NULL){
        
        $data = [];
        
        foreach(self::$data as $key => $val){
            
            if(!is_object($val))
                $data[$val] = $key;
            
        }
        
        if(!isset($data[$actionName])){
            
            return false;
            
        }
        

        if(is_array($params)){

            $route = $data[$actionName];

            foreach($params as $key => $val){
                
                $route = str_replace('{' . $key . '}', $val, $route);
                
            }
            
            return $route;
            
        }
        
        return $data[$actionName];
        
    }
    
    public static function actions($c){
        
        if(!is_array($c))
            $c = [$c];
        
        $count = count($c);
        
        for($i=0;$i<$count;$i++){
            
            $controller = explode('@', $c[$i]);
            
            $mini = explode('Controller', $controller[0]);
            
            $route = '/' . $mini[0] . '/' . $controller[1];
            
            $reflectionMethod = new ReflectionMethod($controller[0], $controller[1]);

            $methParams = $reflectionMethod -> getParameters();
            
            $countP = count($methParams);
            
            for($k=0;$k<$countP;$k++){
                
                $route .= '/{' . $methParams[$k] -> name . '}';
                
            }
            
            self::get($route, $c[$i]);
            
        }
        
        return true;
        
    }
    
    public static function controller($classname, $without = false){
        
        $without = !$without ? [] : $without;
        
        $without = !is_array($without) ? [$without] : $without;
        
        $methods = get_class_methods($classname);
        
        $count = count($methods);
        
        $arr = [];
        
        $without = array_flip($without);
        
        for($i=0;$i<$count;$i++){
            
            if(isset($without[$methods[$i]]))
                continue;
            
            $arr[] = $classname . '@' . $methods[$i];
            
        }
        
        return self::actions($arr);
        
    }
    
    public static function getRouteList(){
        
        if(count(self::$data))
            $data['get'] = array_keys(self::$data);
        
        if(count(self::$post))
            $data['post'] = array_keys(self::$post);
        
        return $data;
        
    }
    
    public static function getControllerList(){
        
        return [
            'get' => self::$data,
            'post' => self::$post
            ];
        
    }

}
?>
