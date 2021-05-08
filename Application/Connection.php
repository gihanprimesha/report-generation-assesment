<?php

namespace Application;

class Connection
{
    private $connection;
    private $serverName, $username, $password;
    private $config;

    public function __construct()
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

    public function __sleep()
    {
        return array('dsn', 'username', 'password');
    }

    public function __wakeup()
    {
        $this->connect();
    }
}
