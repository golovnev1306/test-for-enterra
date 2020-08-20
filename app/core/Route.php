<?php
namespace core;

class Route {
    static function run() 
    {
        global $App;

        $urlParse = parse_url($_SERVER['REQUEST_URI']); //отделим адрес от параметров/фрагментов

        //адрес будет иметь вид /[controller]/[action]/
        $explodedUrl = explode('/', strtolower($urlParse['path']));
        $explodedUrl = $App->arrayDeleteEmpty($explodedUrl);
        $cntParts = count($explodedUrl);
        $params = [];

        //в этом условии - проверяем, имеется ли у данного адреса доп параметры (пример, id детальной новости)
        if ($cntParts > 2) {
            $searchAddrNeedParams = "/{$explodedUrl[0]}/{$explodedUrl[1]}/";
            $addrNeedParams = $App->getConfig('addressNeedParams');

            //есть ли такой адрес в конфиге, которые имеет параметры адреса и совпадает ли их количество 
            if (array_key_exists($searchAddrNeedParams, $addrNeedParams) 
                    && ($cntParts - 2) === $addrNeedParams[$searchAddrNeedParams]) {
                for ($i = 0; $i < $addrNeedParams[$searchAddrNeedParams]; $i++) {
                    $params[] = $explodedUrl[$i + 2];
                }
            } else {
                Controller::error404();
                return;
            }            
        }

        if (isset($explodedUrl[0])) {
            $App->setController($explodedUrl[0]);

            if (isset($explodedUrl[1])) {
                $App->setAction($explodedUrl[1]);
            }
        }

        Controller::start($params);
    }
}