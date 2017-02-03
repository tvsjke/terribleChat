<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if($user->is_logged())
{
    $user->redirect('index.php');
}

$error = null;

if(isset($_POST['btn-login']))
{
    $name = $_POST['txt_login'];
    $pass = $_POST['txt_password'];

    if($user->login($name, $pass))
    {
        $user->redirect('index.php');
    }
    else
    {
        $error = "Неверный логин или пароль!";
    }
}

$v = new View('log-in.html');
$v->render(['error' => $error]);

