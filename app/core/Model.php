<?php

namespace core;

class Model
{
    public $tableName = null;

    public function __construct()
    {
        if (null === $this->tableName) {
            $classname = (new \ReflectionClass($this))->getShortName();//если свойство названия таблицы явно
                                                                        //не задано - возьмем имя класса при помощи 
                                                                        //рефлексии (чтобы получить название класса без namespace)
            $this->tableName = strtolower($classname);
        }
    }

    public function getAll() 
    {
        $db = Db::getInstance();
        $query = "select * from $this->tableName";
        $dbRes = $db->execQuery($query);
        $db->closeConnection();

        return mysqli_fetch_all($dbRes, MYSQLI_ASSOC);
    }

    public function getFirst() 
    {
        $db = Db::getInstance();
        $query = "select * from $this->tableName limit 1";
        $dbRes = $db->execQuery($query);
        $db->closeConnection();

        return mysqli_fetch_assoc($dbRes);
    }
    public function getById($id) 
    {
        $db = Db::getInstance();
        $stmtQuery = "select * from $this->tableName where id=(?)";
        $args[] = [
            'type' => 'i',
            'value' => $id,
        ];
        $dbRes = $db->prepareQuery($stmtQuery, $args);

        return mysqli_fetch_assoc($dbRes);
    }
}