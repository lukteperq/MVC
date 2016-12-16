<?php
class App{

  protected $defaultMethod      = "index";
  protected $defaultController  = "home";
  protected $defaultParameter   = [];

  public function __construct(){
      //echo "virker";
      print_r($this->processUrl());
  }

  public function processUrl(){
    if(isset($_GET['url'])){
      return $url = explode('/', filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));//right trim
      //return $_GET["url"];
    }

  }//processUrl


}
