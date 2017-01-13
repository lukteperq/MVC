<?php
spl_autoload_register(function($class){
  $root = dirname(__DIR__); //parent dir -> ../ from public
  $file = $root.'/'.str_replace('\\', '/', $class).'.php';//converts a namespace to a directory
  if(is_readable($file)){
    require $root.'/'.str_replace('\\', '/', $class).'.php';
  }
});

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('{controller}/{action}/{id:\d+}');
$router->add('{id:\d+}/{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
