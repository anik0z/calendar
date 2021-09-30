<?php

/*
 * Add singleton after
 */

class Connection
{

    /* need to be const */
    private $servername = "localhost";
    private $username = "root";
    private $password = "password";

    private $conn;

    public function __construct()
    {
        if(is_null($this->conn)){
            try {
                $this->conn = new PDO("mysql:host=$this->servername;dbname=calendar", $this->username);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }

    public function run($sql, $args = NULL)
    {
        if (!$args)
        {
            return $this->conn->query($sql);
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public function lastInsertId(){
        return $this->conn->lastInsertId();
    }

}

