<?php
class Home extends Controller{



  public function index($name = ''){
    $post = $this->model('post');
    $post->title = 'skjiitsekk';
    $this->view('Home', ['title' => $post->title]);
    //echo $name;
  }//index()

  public function skjiit(){
    echo "ai æmm skjiiting";
  }//skjiit()




}//class
