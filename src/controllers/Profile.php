<?php

namespace User\Instagram\controllers;

use User\Instagram\lib\Controller;
use User\Instagram\models\User;

class Profile extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserProfile(User $user)
    {
        $user->fetchPosts();
        $this->render('profile/index', ['user'=>$user]);
    }

    public function getUsernameProfile(string $username)
    {
        $user = User::getUser($username);
        $this->getUserProfile($user);
    }
}