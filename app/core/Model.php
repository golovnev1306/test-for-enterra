<?php
defined('INCLUDE_INDEX') or die('Restricted access');
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
        $arr = Cache::get($this->tableName);
        if (!$arr) {
            $db = Db::getInstance();
            $query = "select * from $this->tableName";
            $dbRes = $db->execQuery($query);
            $db->closeConnection();
            $arrDb = mysqli_fetch_all($dbRes, MYSQLI_ASSOC);
            $arr = [];
            foreach ($arrDb as $item) {
                $arr[$item['id']] = $item;
            }

            Cache::create($this->tableName, $arr);
        }
        return $arr;
    }

    //если у нас есть целый массив с новостями в кэше, возьмем первый эл-т оттуда
    //иначе сделаем запрос
    public function getFirst()
    {
        $arr = Cache::get($this->tableName);
        if (!$arr) { 
            $db = Db::getInstance();
            $query = "select * from $this->tableName limit 1";
            $dbRes = $db->execQuery($query);
            $db->closeConnection();
            $result = mysqli_fetch_assoc($dbRes);
        } else {
            $result = array_shift($arr);
        }

        return $result;
    }
    
    public function getById($id)
    {
        $arr = Cache::get($this->tableName);
        if (!$arr) { 
            $db = Db::getInstance();
            $stmtQuery = "select * from $this->tableName where id=(?)";
            $args[] = [
                'type' => 'i',
                'value' => $id,
            ];
            $dbRes = $db->prepareQuery($stmtQuery, $args);
            $result = mysqli_fetch_assoc($dbRes);
        } else {
            $result = $arr[$id];
        }

        return $result;
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
        Cache::delete($this->tableName);
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
        Cache::delete($this->tableName);
        return true;
    }

    public function update($args) {
        $db = Db::getInstance();
        $stmtQuery = "update $this->tableName set name=(?), preview_text=(?), detail_text=(?), image=(?) where id=(?)";
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
            [
                'type' => 'i',
                'value' => intval($args['id']),
            ],
        ];
        
        $db->prepareQuery($stmtQuery, $args);
        $db->closeConnection();
        Cache::delete($this->tableName);
        return true;
    }
}