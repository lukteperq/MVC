<?php
class Router{
  /*matches controller/function....   snerk/skjiit.
  *parantes fordi.   preg_match($regex, "skjiit/doThis", $matches) VIL GI
  * [
      controller => skjiit,
      method => doThis
    ]
  */
  //$regex = "/^(?P<controller>^[a-z]+)\/(?P<method>[a-z]+)$/";

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
       /*
       foreach($this->routes as $route => $params){
         if($url == $route){
           $this->params = $params;
           return true;
         }
       }
       return false;*/

       //$reg_exp = "/^(?P<controller>^[a-z]+)\/(?P<method>[a-z]+)$/";

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


      /* OLD
      if(preg_match($reg_exp, $url, $matches)){
        //get named capture group values, eg.. controller = skjiit
        $params = [];

        foreach($matches as $key => $match){
          if(is_string($key)){
            $params[$key] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
      return false;
      */


     }//match()

     public function getParams(){
       return $this->params;
     }

}//Class
