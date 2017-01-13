<?php
require('../Core/Router.php');
$router = new Router();
//echo "\nClass = ".get_class($router);


//add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('{controller}/{action}/{id:\d+}');
$router->add('{id:\d+}/{controller}/{action}');

/*
echo "<pre>";
print_r($router->getRoutes());
echo "</pre>";
*/
//Match the requested route
$url = $_SERVER['QUERY_STRING'];


echo "<pre>";
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo "</pre>";

if($router->match($url)){
  echo "<pre>";
  var_dump($router->getParams());
  echo "</pre>";
}else{
  echo "no route found for URL = ".$url;
}



//echo preg_replace("/(\w+) eller (\w+)/", '\1 ogsåFORHELVETE \2', "Meg eller deg");
