<?php
defined('INCLUDE_INDEX') or die('Restricted access');
namespace core;

class Cache
{
    static function get(string $nameCacheFile) 
    {
        global $App;

        $fileName = $App->pathToCache() . $nameCacheFile . '.cache';
        if (file_exists($fileName)) {
            $variable = unserialize(file_get_contents($fileName));
            return $variable;
        }
        return false;
    }

    static function create(string $name, Array $arr) 
    {
        global $App;

        $fileName = $App->pathToCache() . $name . '.cache';
        $str = serialize($arr);
        if (false === file_put_contents($fileName ,$str)) {
            return false;
        }
        return true;
    }

    static function delete(string $nameCacheFile) {
        global $App;

        $fileName = $App->pathToCache() . $nameCacheFile . '.cache';
        if (file_exists($fileName)) {
            unlink($fileName);
        }
    }
}