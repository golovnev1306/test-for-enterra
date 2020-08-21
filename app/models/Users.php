<?php
namespace models;

use core\Model;
use core\Db;

class Users extends Model
{
    public $tableName;

    public function login(string $login, string $pass) 
    {
        
        //print_r($this->tableName);
        $db = Db::getInstance();
        $query = "select * from {$this->tableName} where login=(?) and pass=(?) limit 1";

        $args = [
            [
                'type' => 's',
                'value' => $login,
            ],
            [
                'type' => 's',
                'value' => $pass,
            ],
        ];
        $dbRes = $db->prepareQuery($query, $args);
        $db->closeConnection();

        $user = mysqli_fetch_assoc($dbRes);
        if (null !== $user) {
            $_SESSION["autorizeUser"] = $user;
            return true;
        }

        return false;
    }
}