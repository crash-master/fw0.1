<?php
namespace Kernel;

class Components{
	private static $components;
	private static $pathToComponentsSchema;

	/**
	 * [create component]
	 * @param  [string] $name   [component name]
	 * @param  [array] $component [array like pathToView => controller@action or pathToView => [controller@action, ...] ]
	 */
	public static function create($name, $component){
		if(!is_array(self::$components)){
			self::$components = [];
		}
		if(isset(self::$components[$name])){
			Err::add('Components', "Component with name '{$name}' already exist");
			return false;
		}
		self::$components[$name] = $component;
	}

	/**
	 * [getAll Return list with all components]
	 * @return [array] [all components]
	 */
	public static function getAll(){
		return self::$components;
	}

	/**
	 * [get searching components]
	 * @param  [string] $val [path to view or action name or component name]
	 * @param  [string] $row [searching param. Have value 'action' or 'view' or nothing]
	 * @return [array]      [components]
	 */
	public static function get($val, $row = NULL){
		switch($row){
			case 'view': 
				return self::getOnViewPath($val);
			case 'action': 
				return self::getOnAction($val);
		}

		return self::getOnComponentsName($val); // default variant
	}

	/**
	 * [getOnComponentsName searching one components with some name]
	 * @param  [string] $name [name of component]
	 * @return [array]       [one component]
	 */
	public static function getOnComponentsName($name){
		return self::$components[$name];
	}

	/**
	 * [getOnViewPath searching and returning components]
	 * @param  [string] $viewPath [path to view]
	 * @return [array]           [components in array]
	 */
	public static function getOnViewPath($viewPath){
		$ret = [];
		if(!count(self::$components)){
			return [];
		}
		foreach(self::$components as $name => $component){
			foreach($component as $view => $actions){
				if($view == $viewPath){
					$ret[$name] = $component;
				}
			}
		}

		return $ret;
	}

	/**
	 * [getOnAction searching and returning components]
	 * @param  [string] $action [example 'controller@action']
	 * @return [array]         [components]
	 */
	public static function getOnAction($action){
		$ret = [];
		foreach(self::$components as $name => $component){
			foreach($component as $view => $actions){
				foreach($actions as $item => $ac){
					if($ac == $action){
						$ret[$name] = $component;
					}
				}
			}
		}

		return $ret;
	}

	/**
	 * [init function for initialisation ]
	 * @param  [string] $path [path to file with components schema]
	 */
	public static function init($path = NULL){
		self::$pathToComponentsSchema = $path ? $path : './app/components.php';

		if(!file_exists(self::$pathToComponentsSchema)){
			Err::add('Components', 'File components.php (components schema) was not found');
			return false;
		}
	}

	/**
	 * [callToAction for calling action]
	 * @param  [string] $view [path to view]
	 */
	public static function callToAction($view){
		$component = self::getOnViewPath($view);
		if(!count($component)){
			return false;
		}

		Events::register('before_rendered_component', [
            'view' => $view,
            'component' => $component
        ]);

		foreach($component as $name => $item){
			if(!is_array($item[$view])){
				$action = explode('@', $item[$view]);
				View::addVars(call_user_func(array($action[0],$action[1])));
			}else{
				$count = count($item[$view]);
				for($i=0; $i<$count; $i++){
					$action = explode('@', $item[$view][$i]);
					View::addVars(call_user_func(array($action[0],$action[1])));
				}
			}
		}
	}

}