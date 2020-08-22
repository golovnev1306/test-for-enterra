<?php
defined('INCLUDE_INDEX') or die('Restricted access');

return [
    'defaultController' => 'news',
    'defaultAction' => 'index',
    'layout' => 'mainLayout',
    '404Controller' => 'error404',
    '404Action' => 'index',
    'dbHost' => 'localhost',
    'dbName' => 'test_enterra',
    'dbUser' => 'root',
    'dbPass' => '',
    'dateFormat' => 'd.m.Y',
    'addressNeedParams' => [ //адреса у которых будут доп параметры (пример: детальная новость) => кол-во
        '/news/detail/' => 1,
    ],
];