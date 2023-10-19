<?php

require_once('../src/data.php');

if (isset($_POST)) {
    //https://www.phpmentoring.org/blog/php-file-get-contents
    $data = file_get_contents('php://input');

    //redirect to home page if data is empty
    if (empty($data)) {
        header('Location: /');
        unset($_POST);
    }

    $userPost = json_decode($data, true);
    $response =  addPost($userPost['title'], $userPost['content'], $userPost['user_id']);
    echo $response;
}

exit();
