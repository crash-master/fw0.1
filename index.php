<?php

include('fw/fw.php');

//$res = DBW::s() -> table('t1') -> rows() -> run();
//$res = DBW::d() -> table('t1') -> where(array('name','=','val1')) -> run();
//$res = DBW::i() -> table('t1') -> rows(array('name'=>'hello','date'=>'NOW()')) -> run();
//$res = DBW::u() -> table('t1') -> rows(array('name'=>'test','date'=>'NOW()')) -> where(array('name','=','val2')) -> run();
//dd($res);
/*DBIO::create(array(
    'new'=>array(
        'row_one'=>array('int(10)'=>array('0'=>'NULL')),
        'row_two'=>array('varchar(100)'=>array('1'=>'hello'))
    )
));*/

/*DBW::create(2,function($t){
    $t[0] -> table('experement') -> row('one') -> int(5) -> notnull(1);
    $t[1] -> row('two') -> varchar() -> _null('Hello');
});

DBW::drop('experement');*/
?>