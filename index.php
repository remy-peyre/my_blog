<?php

use Router\Router;
use Symfony\Component\Yaml\Yaml;

session_start();

require __DIR__ . '/vendor/autoload.php';

$config = Yaml::parse(file_get_contents('config/config.yml'));

$loader = new Twig_Loader_Filesystem('views/');
$twig = new Twig_Environment($loader, array(
    // 'cache' => 'cache/twig/',
    'cache' => false,
    'debug' => true,
));

$twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
    // implement whatever logic you need to determine the asset path

    return sprintf('../assets/%s', ltrim($asset, '/'));
}));

$twig->addExtension(new Twig_Extension_Debug());

$router = new Router($config['routes'], $twig);
if (!empty($_GET['action']))
    $router->callAction($_GET['action']);
else
    $router->callAction($config['defaut_route']);
