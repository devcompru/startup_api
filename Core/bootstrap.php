<?php
declare(strict_types=1);
require_once "../vendor/autoload.php";

require_once "functions.php";




$router = [
    [
        'method'=>'GET', 'pattern'=>'v1/main/test', 'controller'=>\App\Modules\main\controllers\MainController::class,'action'=>'actionTest'
    ],
    [
        'method'=>'GET', 'pattern'=>'v1/main/test/<item1:[0-9a-zA-Z-_.]{0,}>/<item2:[0-9a-zA-Z-_.]{0,}>', 'controller'=>\App\Modules\main\controllers\MainController::class,'action'=>'actionTest2'
    ]

];

$data = new \Devcompru\Router\Router($router);
MOX($data);
//new \Devcompru\Request();
//var_dump($data->getRoute());



/**
 *
[   'method'=>'GET',
'pattern'=>'v1/admin/access>',
'route'=>['version'=>'v1','module'=>'admin','controller'=>'access', 'action'=>'actionCheckAccess']
],
 *
 */