<?php
namespace core;

class Db 
{
    private static $instance = null;
    private $connection = null;
    private $host;
    private $user;
    private $password;
    private $database;

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            global $App;
            self::$instance = new self();
            self::$instance->host = $App->getConfig('dbHost');
            self::$instance->user = $App->getConfig('dbUser');
            self::$instance->password = $App->getConfig('dbPass');
            self::$instance->database = $App->getConfig('dbName');
            self::$instance->startConnection();
        }
        return self::$instance;
    }

    public function startConnection() 
    {
        self::$instance->connection = mysqli_connect(
            self::$instance->host, 
            self::$instance->user, 
            self::$instance->password, 
            self::$instance->database
        ) or die("Ошибка " . mysqli_error(self::$instance->connection));
    
    }

    public function execQuery($query) 
    {
        return mysqli_query(self::$instance->connection, $query);
    }

    public function closeConnection() 
    {
        mysqli_close(self::$instance->connection);
    }

    private function __clone() {}
    private function __construct() {}
}