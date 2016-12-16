<?php
class App{

  protected $defaultMethod      = "index";
  protected $defaultController  = "Home";
  protected $defaultParameter   = [];

  public function __construct(){
      $url = $this->processUrl();//get the URL -> controller/method/params


      //$url[0] = controller, 1 = method, 2..+n = Params



      //controller
      if(file_exists('../app/controllers/'.$url[0].'.php')){
        $this->defaultController = $url[0];
        unset($url[0]);
      }
      require_once('../app/controllers/'.$this->defaultController.'.php');
      $this->defaultController = new $this->defaultController;



      //Method
      if($url[1]){
        if(method_exists($this->defaultController, $url[1])){
          $this->defaultMethod = $url[1];
          unset($url[1]);
        }
      }


      //parameters
      $this->defaultParameter = $url ? array_values($url) : [];
      //print_r($this->parameters);

      call_user_func_array([$this->defaultController, $this->defaultMethod], $this->defaultParameter);

  }//__construct()

  public function processUrl(){
    if(isset($_GET['url'])){
      //The FILTER_SANITIZE_URL filter removes all illegal URL characters from a string. This filter allows all letters, digits and $-_.+!*'(),{}|\\^~[]`"><#%;/?:@&=
      return $url = explode('/', filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
    }

  }//processUrl()


}
