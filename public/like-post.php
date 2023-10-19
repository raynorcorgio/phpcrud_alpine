<?php

require_once '../src/data.php';

if (isset($_POST)) {

    $data = file_get_contents('php://input');

    if (empty($data)) {
        header('Location: /');
        unset($_POST);
    }

    $post = json_decode($data, true);
    $response = likePost($post['postId'], $post['userId']);

    echo $response;
}

exit();

