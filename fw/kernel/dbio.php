<?php

// DBIO - v2.0 (Connect v4.0))


class Connect{
	public static $config;
    public static $countQuery;
	public static $connect;
	
	public static function start(){
        self::$config = Config::get('system -> DB');
        self::open_connect();
        self::$countQuery = 0;
		return true;
	}
	
	private static function open_connect(){
        
        $dsn = self::$config['dbtype'] . ':host=' . self::$config['host'] . ';dbname=' . self::$config['dbname'] .';charset=' . self::$config['charset'];
        
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        
        self::$connect = new PDO($dsn, self::$config['user'], self::$config['password'], $opt);
        
		if(!self::$connect){
            Err::add('SQL ERROR', 'Error connect');
			return false;
		}

		return true;
	}
	
	public static function close_connect(){
        
        Log::add('SQL query count', self::$countQuery);
        
		return true;
	}
	
	public static function query($sql){
        
        Events::register('before_db_query', ['sql' => $sql]);
        
        $result = strstr($sql, 'SELECT') ? self::$connect -> query($sql) -> fetchAll(PDO::FETCH_ASSOC) : self::$connect -> query($sql);
        
        Events::register('after_db_query', ['result' => $result]);
        
		if(!$result){
            Err::add('SQL ERROR', $sql);
		 	return 0;
		}
        
        self::$countQuery++;
        
		return $result;
	}
}

class DBIO{
    
    public static function start(){
        Connect::start();
        return true;
    }
    
    public static function end(){
        
        Connect::close_connect();
        
        return true;
        
    }
    
    
    public static function select($params){ // $table - string, $rows - array, $where - array, $limit - array(from,count), $sort - DESC || ASC, $many - true || false) || $sql - string
        
        if(!isset($params['table'])){
            return false;
        }

        if(!isset($params['rows'])){
            $params['rows'] = '*';
        }else{
            $count = count($params['rows']);
            for($i=0;$i<$count;$i++){
                $params['rows'][$i] = addslashes($params['rows'][$i]);
            }
            $params['rows'] = implode('`,`',$params['rows']);
            $params['rows'] = '`'.$params['rows'].'`';
        }

        $sql = 'SELECT '.$params['rows'].' FROM `'.addslashes($params['table']).'`';
        $sql2 = '';
        if(isset($params['where']) and is_array($params['where'])){
            $sql2 .= self::arrToSqlWhere($params['where']);
        }
        
        if(isset($params['order']) and is_array($params['order']))
            $sql2 .= ' ORDER BY `'.addslashes($params['order'][0]).'` '.addslashes($params['order'][1]);
        if(isset($params['limit']) and is_array($params['limit']))
            $sql2 .= ' LIMIT '.addslashes($params['limit'][0]).','.addslashes($params['limit'][1]);
        $sql .= $sql2;
        
        return self::fq($sql);
    }
    
    public static function arrToSqlWhere($where){
        $sql = '';
        $count = count($where);
        if($count > 3){
            $sql .= ' WHERE ';
            for($i=0;$i<$count;$i += 3){

                $sql .= '`'.addslashes($where[$i]).'`'.$where[$i+1].'\''.addslashes($where[$i+2]).'\'';

                if(isset($where[$i + 3])){
                    $sql .= ' ' . strtoupper(addslashes($where[$i + 3])) . ' ';
                    $i++;
                }

            }
        }else
            $sql .= ' WHERE `'.addslashes($where[0]).'`'.$where[1].'\''.addslashes($where[2]).'\''; 
        
        return $sql;
        
    }
    
    public static function update($params){
        
        if(!is_array($params)){
            $sql = $params;
        }else{
            if(!isset($params['table']) or ((!isset($params['rows']) or !isset($params['rowsdata'])) and !isset($params['data']))){
                return false;
            }
            if(isset($params['data'])){
                $params['rows'] = array_keys($params['data']);
                $params['rowsdata'] = array_values($params['data']);
            }
            $sql = 'UPDATE `'.$params['table'].'` SET ';
            $count = count($params['rows']);
            if($count != count($params['rowsdata'])){
                return false;
            }
            for($i=0;$i<$count;$i++){
                if($i) $sql .= ',';
                if($params['rowsdata'][$i] != 'NOW()'){
                    $sql .= '`'.addslashes($params['rows'][$i]).'`=\''.addslashes($params['rowsdata'][$i]).'\'';
                }else{
                    $sql .= '`'.addslashes($params['rows'][$i]).'`='.addslashes($params['rowsdata'][$i]);
                }
            }
            if(isset($params['where']) and is_array($params['where'])){
                $sql .= self::arrToSqlWhere($params['where']);
            }
        }
        return Connect::query($sql);
    }
    
    
    
    public static function insert($params){ // $rowsdata - array
        if(!is_array($params)){
            $sql = $params;
        }else{
            if(!isset($params['table']) or ((!isset($params['rows']) or !isset($params['rowsdata'])) and !isset($params['data']))){
                return false;
            }
            if(isset($params['data'])){
                $params['rows'] = array_keys($params['data']);
                $params['rowsdata'] = array_values($params['data']);
            }
            $sql = 'INSERT INTO `'.$params['table'].'`(';
            $count = count($params['rows']);
            if($count != count($params['rowsdata'])){
                return false;
            }
            for($i=0;$i<$count;$i++){
                if($i) $sql .= ',';
                $sql .= '`'.addslashes($params['rows'][$i]).'`';
            }
            $sql .= ') VALUES (';
            
            for($i=0;$i<$count;$i++){
                if($i) $sql .= ',';
                if($params['rowsdata'][$i] == 'NOW()')
                    $sql .= 'NOW()';
                else
                    $sql .= '\''.addslashes($params['rowsdata'][$i]).'\'';
            }
            
            $sql .= ')';
        }
        return Connect::query($sql);
    }
    
    
    
    public static function delete($params){
        if(!is_array($params)){
            $sql = $params;
        }else{
            if(!isset($params['table'])){
                return false;
            }
            $sql = 'DELETE FROM `'.$params['table'].'` ';

            if(isset($params['where']) and is_array($params['where'])){
                $sql .= self::arrToSqlWhere($params['where']);
            }
        }
        
        return Connect::query($sql);
    }
    
    public static function fq($sql){
        $res = Connect::query($sql);
        if(is_array($res) and !isset($res[1]))
            return $res[0];
        return $res;
    }
    
    public static function create($params){ // доработать
        $table = array_keys($params);
        $table = $table[0];
        $rows = array_keys($params[$table]);
        $count = count($rows);
        $types = array();
        $default = array();
        $null = array();
        for($i=0;$i<$count;$i++){
            $tmp = array_keys($params[$table][$rows[$i]]);
            $types[$i] = $tmp[0];
            $tmp = array_keys($params[$table][$rows[$i]][$types[$i]]);
            $null[$i] = $tmp[0]; // $null = 1 or 0
            $default[$i] = $params[$table][$rows[$i]][$types[$i]][$null[$i]];
        }
        
        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,";
        for($i=0;$i<$count;$i++){
            $sql .= '`'.$rows[$i].'` '.$types[$i];
            if(empty($null[$i]))
                $sql .= ' NOT NULL';
            if(!empty($default[$i]) and $default[$i] != 'undef'){
                if($default[$i] == 'NULL')
                    $sql .= ' DEFAULT '.$default[$i];
                else
                    $sql .= ' DEFAULT \''.$default[$i].'\'';
            }
            $sql .= ',';
        }
        $sql .= 'PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
        return DBIO::fq($sql);
    }
    
    
    
    public static function drop($table){
        if(empty($table))
            return false;
    }
    
    public static function columns($tablename){
//        return self::fq('SHOW COLUMNS FROM `'.$tablename.'`');
        $q = Connect::$connect -> prepare("DESCRIBE `{$tablename}`");
        $q -> execute();
        return $q -> fetchAll(PDO::FETCH_COLUMN);
        
    }
    
    public static function getTimeOfCreate($tablename){
        $res = self::getStatusOfTables();
        $count = count($res);
        for($i=0;$i<$count;$i++){
            if($res[$i]['Name'] == $tablename){
                return $res[$i]['Create_time'];
            }
        }
        return false;
    }
    
    public static function getStatusOfTables(){
        return self::fq('SHOW TABLE STATUS FROM `'.Connect::$config['dbname'].'`');
    }
    
    public static function getCountResults($tablename = false, $where = false){
        
        if(!$tablename)
            return false;
        
        $tablename = addslashes($tablename);
        
        $sql = "SELECT COUNT(*) FROM `{$tablename}`";
        
        if($where and is_array($where)){
            $sql .= self::arrToSqlWhere($where);
        }
        
        return self::fq($sql);
        
    }
    
    public static function truncate($tablename){
        return self::fq('TRUNCATE TABLE `'.$tablename.'`');
    }
}
