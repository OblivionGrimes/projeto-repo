<?php

namespace src\Core;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {

    protected PDO $mysqlConnection;

    private string $host;
    private string $username;
    private string $databasepassword;
    private string $databaseName;

    public function __construct() {

        $Dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
        $Dotenv->load();

        $this->host = $_ENV['HOSTNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->databasepassword = $_ENV['DB_PASSWORD'];
        $this->databaseName = $_ENV['DB_DATABASE'];

        $dsn = "mysql:host={$this->host};dbname={$this->databaseName};charset=utf8mb4";

        try {
            $this->mysqlConnection = new PDO(
                $dsn,
                $this->username,
                $this->databasepassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                    PDO::ATTR_EMULATE_PREPARES => false 
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}


