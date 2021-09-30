<?php

include_once __DIR__ . '/../../Model/Repository/UserRepository.php';
include_once __DIR__ . '/../../Controller/UserController.php';

if(isset($_POST["username"])){
    if(isset($_POST["password"])){
        $userController = new UserController();
        $existUser = $userController->login($_POST["username"],$_POST["password"]);
        if($existUser->getId() !== null){
            /*
             * ADD COOKIE WITH USER INFORMATION!!
             */
            setcookie("currentUser", $existUser->getId()."", time() + (86400 * 30), "/");
            // Redirect
            header("Location: ../../View/index.php");
        }else{
            /*
             * Error Handle
             */
            echo "dont exist, register please";
            die();
        }
    }
}

?>
