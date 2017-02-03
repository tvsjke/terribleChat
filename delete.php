<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if(isset($_POST['post_id'])) {
    $post_id = trim($_POST['post_id']);
    $model->postDelete($post_id);
}

$user->redirect('index.php');