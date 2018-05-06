<?php

namespace Extend;

class Model{
    
    public function q($sql){
        
        return \DBIO::fq($sql);
        
    }
    
    public function get($params = NULL){
        
        $where = isset($params['where']) ? $params['where'] : NULL;
        
        return (new \Essence($this -> sets)) -> get($where, $params);
        
    }
    
    public function all($type = "ASC"){
        
        return (new \Essence($this -> sets)) -> get(NULL, [
            
            'order' => ['id', $type]
            
        ]);
        
    }
    
    public function first(){

        return (new \Essence($this -> sets)) -> get(NULL, [
            
            'order' => ['id', 'ASC'],
            
            'limit' => [0, 1]
            
        ]);

    }
    
    public function last(){

        return (new \Essence($this -> sets)) -> get(NULL, [

            'order' => ['id', 'DESC'],

            'limit' => [0, 1]

        ]);

    }
    
    public function set($data){

        return (new \Essence($this -> sets)) -> set($data);

    }
    
    public function remove($where = false){

        return (new \Essence($this -> sets)) -> del($where);

    }
    
    public function update($data, $where = false){
        
        return (new \Essence($this -> sets)) -> edit($data, $where);
        
    }
    
    public function length($where = false){
        
        return (new \Essence($this -> sets)) -> length($where);
        
    }
    
    public function truncate(){
        return (new \Essence($this -> sets)) -> truncate();
    }
    
}