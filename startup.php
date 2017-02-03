<?php

//some settings here
if (file_exists('config.php')) {
    require_once('config.php');
}

error_reporting(E_ALL);

session_start();

if(!function_exists('classAutoLoader')){
    function classAutoLoader($class){
        $class=strtolower($class);
        $classFile=$_SERVER['DOCUMENT_ROOT'].'/class/'.$class.'.class.php';
        if(is_file($classFile)&&!class_exists($class)) include $classFile;
    }
}
spl_autoload_register('classAutoLoader');


$db = new MySQLdb($DB_host, $DB_name, $DB_user, $DB_pass);

$model = new Model($db);

$user = new User($model);