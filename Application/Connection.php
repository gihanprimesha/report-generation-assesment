<?php

namespace Application;

use Application\Connection as ApplicationConnection;

class Connection
{
    private $connection;
    private $serverName, $username, $password;
    private $config;
    public static $instance;

    private function __construct()
    {
        if (!(include 'Configs/local.php')) {
            throw new \Exception('Database configurations not found');
        }

        $this->config = include 'Configs/local.php';

        $this->serverName = $this->config['server_name'];
        $this->username = $this->config['user_name'];
        $this->password = $this->config['password'];
        $this->dbname = $this->config['db_name'];
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->connection = new \PDO("mysql:host=$this->serverName;dbname=$this->dbname", $this->username, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnction()
    {
        if (isset($this->connection)) {
            $this->connect();
        }

        return $this->connection;
    }

    public static function getInstance()
    {
        if (!isset(Connection::$instance)) {
            Connection::$instance = new Connection();
        }

        return Connection::$instance;
    }
}
