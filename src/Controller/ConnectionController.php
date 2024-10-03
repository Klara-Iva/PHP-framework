<?php

namespace Src\Conntroller;

use PDO;
use PDOException;
use Src\Database\Connection;

class ConnectionController{

    private static $instance = null;
    private $pdo;

    private function __construct() //private constructor so none can directly make a new instance
    {
        $dsn = 'mysql:host=localhost; dbname=database_name';
        $username = 'username';
        $password = 'password';

        try {//error handling
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

    public static function getInstance(): Connection //fetches existing instance or makes a new one, SINGLETON
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
    
}