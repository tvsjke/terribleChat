<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if(isset($_POST['post_id']) && isset($_POST['post_msg'])) {
    $post_id = trim($_POST['post_id']);
    $msg = htmlentities(trim($_POST['post_msg']));
    $homepage = isset($_POST['post_homepage']) ? trim($_POST['post_homepage']) :'';

    $model->postEdit($post_id, $msg, $homepage);

    echo json_encode(['success' => true]);
}