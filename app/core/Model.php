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

    public function add($args)
    {
        $db = Db::getInstance();
        $stmtQuery = "insert into $this->tableName (name, preview_text, detail_text, image) values ((?), (?), (?), (?))";
        $args = [
            [
                'type' => 's',
                'value' => $args['name'],
            ],
            [
                'type' => 's',
                'value' => $args['preview_text'],
            ],
            [
                'type' => 's',
                'value' => $args['detail_text'],
            ],
            [
                'type' => 's',
                'value' => $args['image'],
            ],
        ];
        $db->prepareQuery($stmtQuery, $args);
        $db->closeConnection();
        return true;
    }

    public function delete($id)
    {
        $db = Db::getInstance();
        $stmtQuery = "delete from $this->tableName where id=(?)";
        $args = [
            [
                'type' => 'i',
                'value' => $id,
            ]
        ];
        $db->prepareQuery($stmtQuery, $args);
        $db->closeConnection();
        return true;
    }
}