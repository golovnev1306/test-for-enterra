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
        return mysqli_fetch_all($dbRes, MYSQLI_ASSOC);
    }
}