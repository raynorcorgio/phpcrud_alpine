<?php

require_once("../src/data.php");

session_start();

function isUserLoggedIn() {
    return isset($_SESSION['user']);
}

function login($username, $password) {
    $user = getUserByUsername($username);

    if ( $user && password_verify($password, $user['password']) ) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function logout() {
    unset($_SESSION['user']);
}

function getCurrentUser(){
    if ( !isUserLoggedIn() ) {
        return null;
    }
    return $_SESSION['user']['username'];
}

function isAdmin() {
    if (getCurrentUser() == "admin") {
        return true;
    } else {
        return false;
    }
}

function getUserId() {
    if ( !isUserLoggedIn() ) {
        return null;
    }
    return $_SESSION['user']['id'];
}