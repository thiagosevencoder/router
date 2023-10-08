<?php

require 'vendor/autoload.php';

use SevenCoder\Router\Router;

$router = new Router('http://localhost/router', '@');

$baseDir = __DIR__.'/App/Controller';

$router->setBasePath($baseDir);

$router->get('/', 'HomeController@index');
$router->get('teste/{teste}/{teste2}', 'HomeController@teste');

$router->prefix('teste-prefix');
$router->get('1/{param1}/{param2}', 'HomeController@teste');
$router->get('2', 'HomeController@teste2');

$router->dispatch();
