<?php

require_once('../src/data.php');

// var_dump($_POST);
//if ( $_POST ) {
if (isset($_POST)) {

    $data = file_get_contents('php://input');

    if (empty($data)) {
        header('Location: /');
        unset($_POST);
    }

    $postId = json_decode($data, true);
    deletePost($postId['id']);
//    echo "Post deleted";
}