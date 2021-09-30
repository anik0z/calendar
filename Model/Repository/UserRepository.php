<?php

/*
 * Create the connection to database
 */
include_once __DIR__ . '/../Class/User.php';
include_once __DIR__ . '/../../Util/Connection.php';

class UserRepository
{

    public function addUser($user){
        $exist = false;

        $conn = new Connection();
        /*
         * Check if the user exist
         */
        $sql = "SELECT id,username,password FROM user WHERE username=:uname";
        $args = ['uname' => $user->getUsername()];

        $stmt = $conn->run($sql,$args);

        while($row = $stmt->fetch()){
            $exist = true;
        }

        $passwordCrypto = sha1($user->getPassword());

        if(!$exist){
            $sql = "INSERT INTO user (username, password) VALUES (?,?)";
            $args = [$user->getUsername(),$passwordCrypto];
            $conn->run($sql,$args);
        }

        return $exist;
    }

    public function haveUser($user){
        $conn = new Connection();
        // select a particular user by id
        $passwordCrypto = sha1($user->getPassword());

        $sql = "SELECT id,username,password FROM user WHERE username=:uname AND password=:psw";
        $args = ['uname' => $user->getUsername() ,'psw' => $passwordCrypto];

        $stmt = $conn->run($sql,$args);
        $existUser = new User();

        while ($row = $stmt->fetch()) {
            $existUser->setId($row["id"]);
            $existUser->setUsername($row["username"]);
            $existUser->setPassword($row["password"]);
        }
        return $existUser;
    }

    public function findById($id){
        $conn = new Connection();
        // select a particular user by id

        $sql = "SELECT id,username,password FROM user WHERE id=:id";
        $args = ['id' => $id];

        $stmt = $conn->run($sql,$args);
        $existUser = new User();

        while ($row = $stmt->fetch()) {
            $existUser->setId($row["id"]);
            $existUser->setUsername($row["username"]);
            $existUser->setPassword($row["password"]);
        }
        return $existUser;
    }

}
