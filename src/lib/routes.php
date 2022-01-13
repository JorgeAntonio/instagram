<?php

use User\Instagram\controllers\Actions;
use User\Instagram\controllers\Home;
use User\Instagram\controllers\Login;
use User\Instagram\controllers\Profile;
use User\Instagram\controllers\Signup;

$router = new \Bramus\Router\Router();
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config' );
$dotenv->load();

function notAuth(){
    if (!isset($_SESSION['user'])){
        header('location: /instagram/login');
        exit();
    }
}

function auth(){
    if (isset($_SESSION['user'])){
        header('location: /instagram/home');
        exit();
    }
}

$router->get('/', function (){
    echo 'Inicio';
    echo $_ENV['DB'];
});

$router->get('/login', function (){
    auth();
    $controller = new Login;
    $controller->render('login/index');
});

$router->post('/auth', function (){
    auth();
    $controller = new Login;
    $controller->auth('login/index');
});

$router->get('/signup', function (){
    auth();
    $controller = new Signup;
    $controller->render('signup/index');
});

$router->post('/register', function (){
    auth();
    $controller = new Signup;
    $controller->register();
});

$router->get('/home', function (){
    notAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Home($user);
    $controller->index();
});

$router->post('/publish', function (){
    notAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Home($user);
    $controller->store();
});

$router->get('/profile', function (){
    notAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Profile;
    $controller->getUserProfile($user);
});

$router->post('/addlike', function (){
    notAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Actions($user);
    $controller->like();
});

$router->get('/signout', function (){
    notAuth();
    unset($_SESSION['user']);
    header('location: /instagram/login');
});

$router->get('/profile/{username}', function ($username){
    notAuth();
    $controller = new Profile;
    $controller->getUsernameProfile($username);
});

$router->run();