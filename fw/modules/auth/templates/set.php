<?php

/* PATH: app/sets/ */

namespace Sets;

class /*$name*/Set extends \Extend\Set{

    public function tableName(){ 

        return '/*$name*/'; 

    }

    public $errLoginText = 'Incorrect login or password';

    public function afterAdding(){

        return redirect('/');

    }

    public function rules(){

        return [

            'email' => ['uniqemail' => $this -> tableName()],

            'password' => ['password' => 5]

        ];

    }

    public function defaultRows(){

        return [

            'date' => 'NOW()'

        ];

    }

}