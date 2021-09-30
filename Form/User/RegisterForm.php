<?php

include_once __DIR__ . '/../../Model/Repository/UserRepository.php';
include_once __DIR__ . '/../../Controller/UserController.php';

if(isset($_POST["username"])) {
    if (isset($_POST["password"])) {
        $userController = new UserController();
        $existUser = $userController->signup($_POST["username"], $_POST["password"]);

        if ($existUser) {
            /*
             * Error handle
             */
            var_dump("exist");
            die();
        } else {
            // Redirect
            header("Location: ../../View/User/login.php");
        }
    }
}
