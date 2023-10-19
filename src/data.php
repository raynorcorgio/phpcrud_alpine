<?php

function db() {

    $DB_HOST = 'mysql';
    $DB_NAME = getenv('MYSQL_DATABASE');
    $DB_USERNAME = getenv('MYSQL_USER');
    $DB_PASSWORD = getenv('MYSQL_PASSWORD');

    return new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);
}

function getPosts() {
    return db()->query('select * from posts order by created_at desc')->fetchAll(PDO::FETCH_ASSOC);
}

function getUserByUsername($username) {
    $stmt = db()->prepare('select * from users where username = :username');
    $stmt->execute(['username' => $username]);
    return $stmt->fetch();
}

function addPost($title, $content, $user_id) {
    $sql = 'insert into posts (title, content, user_id, created_at, updated_at) values (:title, :content, :user_id, now(), now())';
    $stmt = db()->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    //return getfullPostData();
    return json_encode(getFullPostData()) ;
}


function getFullPostData() {
    $sqlStr = "SELECT
                    u.username
                    ,p.*
                    ,COALESCE(tblInner.likes_count, 0) as likes_count
                FROM users u
                JOIN posts p on u.id = p.user_id
                LEFT JOIN (
                            SELECT
                            post_id
                            ,COUNT(l.post_id) likes_count
                            FROM likes l
                            JOIN posts p ON p.id = l.post_id
                            JOIN users u ON l.user_id = u.id
                            GROUP BY l.post_id
                        ) tblInner
                ON p.id = tblInner.post_id
                ORDER BY p.created_at DESC;";
    return db()->query($sqlStr)->fetchAll(PDO::FETCH_ASSOC);
}


function deletePost($id) {
    $sql = 'delete from posts where id = :id';
    $stmt = db()->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function likePost($id, $user_id) {
    $sql = 'insert into likes (post_id, user_id, created_at, updated_at) values (:post_id, :user_id, now(), now())';
    $stmt = db()->prepare($sql);
    $stmt->bindParam(':post_id', $id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    //Return the current number of likes for the given post
    $sql = 'select count(*) as likes from likes where post_id = :post_id';
    $stmt = db()->prepare($sql);
    $stmt->bindParam(':post_id', $id);
    $stmt->execute();
//    return $stmt->fetch();

    return json_encode($stmt->fetch());
}