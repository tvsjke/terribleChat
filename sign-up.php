<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if($user->is_logged())
{
    $user->redirect('dashboard.php');
}

$error = [];
//TO DO pass user to view

if(isset($_POST['btn-signup']))
{
    $name = trim($_POST['txt_name']);
    $mail = trim($_POST['txt_mail']);
    $pass = trim($_POST['txt_pass']);

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Введите действительный e-mail !';
    }
    else
    {

            /*$stmt = $DB_handle->prepare("SELECT name, email FROM users WHERE name=:name or email=:mail");
            $stmt->execute([':name'=>$name, ':mail'=>$mail]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);*/

            $row = $model->userCheckIfNameAndEmailExist($name, $mail);

            if($row['name']==$name) {
                $error[] = "Такой логин уже существует.";
            }
            else if($row['email']==$mail) {
                $error[] = "Такой e-mail уже существует";
            }
            else
            {
                $user->register($name, $mail, $pass);
                $user->redirect('sign-up.php?joined');
            }

    }
}

$v = new View('sign-up.html');
$v->render(['error' => $error]);