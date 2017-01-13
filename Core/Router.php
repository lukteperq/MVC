<?php

namespace Core;

class Router{

  /**
   *  Associative Array with the routes (The routing table)
   *  @Var array
   */
  protected $routes = [];

/**
 *  Parameters from the matched Route
 *  @var array
 */
  protected $params = [];


/**
 *  Add a route to the routing table
 *  @param String route, The route URL.
 *  @param array $params. Parameters (Controller, action, vars, etc..)
 *  @return void
 *
 */
  public function add($route, $params = []){
    //$this->routes[$route] = $params;  OLD!!

    //Convert the route to a regular expression. Escape forward slashes --->   {controller/action{ ->  {controller\/action}
    $route = preg_replace('/\//', '\\/', $route);

    //convert variables eg: {controller}
    $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)', $route);
    //{controller}/{action}  converts to ->    (?P<controller>[a-z-]+)/(?P<action>[a-z-]+)

    //Convert variables with custom regular expressions eg {id:\d+}
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)', $route);

    //add start and end delimiters, and case insensitive flags
    $route = '/^'.$route.'$/i';

    $this->routes[$route] = $params;
  }//add()


  /**
   *  get all the routes from the routing table
   *  @return array
   */
    public function getRoutes(){
      return $this->routes;
    }//getRoutes()


    /**
     *  Match the route to the routes in the routing table, setting the params property
     *  if the route is found.
     *  example: if url = home... goto index.php
     *  @param String $url, The route URL.
     *  @return boolean true if found match
     */
     public function match($url){

       foreach($this->routes as $route => $params){
         if(preg_match($route, $url, $matches)){
           foreach($matches as $key => $match){
             if(is_string($key)){
               $params[$key] = $match;
             }
           }
           $this->params = $params;
           return true;
         }
       }
       return false;
     }//match()

     public function getParams(){
       return $this->params;
     }

     public function dispatch($url){
       if($this->match($url)){
         $controller = $this->params['controller'];
         $controller = $this->convertToStudlyCaps($controller); //eks: view-skjiit/snerk -> viewSkjiit  Controller
         $controller = "App\Controllers\\$controller"; //adding namepsapce

         if(class_exists($controller)){
           $controllerObject = new $controller;
           $action = $this->params['action'];
           $action = $this->convertToCamelCase($action);

           if(is_callable([$controllerObject, $action])){
             $controllerObject->$action();

           }else{//no method
             echo "Method $action (in controller $controller) can not be found";
           }
         }else{//no class
           echo "Controller class $controller can not be found";
         }
       }else{//no matchng RouteSetup
         "No matching routeSetupd found";
       }
     }//dispatch()

/**
 * Converts String from some-class -> SomeClass
 */
     public function convertToStudlyCaps($string){
       return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
     }//convertToStudlyCaps()

     public function convertToCamelCase($string){
       return lcfirst($this->convertToStudlyCaps($string));
     }//convertToCamelCase()

}//Class
