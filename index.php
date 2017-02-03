<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

$user_data = [];

if (isset($_GET['logout'])) {
    unset($_SESSION['user_session']);
}

if($user->is_logged())
{
    $user_id = $_SESSION['user_session'];

    $user_data = $model->getUser($user_id);
}

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

$start = $LIMIT * ($page - 1);

$posts = $model->getPosts($start, $LIMIT);

$posts_count = $model->getPostsCount();

$pages_count = (int)ceil($posts_count/$LIMIT);

$pagination = Pagination::render($page, $pages_count);

$v = new View('index.html');
$v->render(['user' => $user_data, 'pagination' => $pagination, 'posts' => $posts]);