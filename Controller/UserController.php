<?php

include_once __DIR__ . '/../Model/Repository/UserRepository.php';

class UserController
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getUser($idCurrentUser){
        $currentUser = $this->userRepository->findById($idCurrentUser);
        return $currentUser;
    }

    public function login($username,$password){
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $existUser = $this->userRepository->haveUser($user);
        return $existUser;
    }

    public function signup($username,$password){
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $existUser = $this->userRepository->addUser($user);
        return $existUser;
    }

}
