<?php
require_once File::getApp(array("models", "ModelProduct.php"));

class ControllerProduct {
  protected static $object = "product";

  public static function readAll(){
    $page_title = 'Boutique';
    $view = 'list';
    $tab_prod = ModelProduct::selectAll();
    require File::getApp(array("views", "view.php"));
  }

  public static function read(){

    $value = ModelProduct::select($_GET['id']);

    if ($value){
      $page_title = 'Détail du produit';
      $view = 'detail';
      require(File::getApp(array("views", "view.php")));
    }else{
      $page_title = 'Détail du produit';
      $view = 'error';
      require(File::getApp(array("views", "view.php")));
    }
  }

  public static function create(){
    $page_title = 'Créer un produit';
    $view = 'create';
    require File::getApp(array("views","view.php"));
  }

  public static function created(){
    $tag = ($_POST['tag']);
    $discount = ($_POST['discount']);
    $name = ($_POST['name']);
    $desc = ($_POST['description']);
    $price = ($_POST['price']);
    ModelProduct::create($tag,$discount,$name,$desc,$price);
    ControllerProduct::readAll();

  }

  public static function delete(){
    ModelProduct::delete($_GET['id']);
    ControllerProduct::readAll();
  }

  public static function update(){

    $value = ModelProduct::select($_GET['id']);

    $page_title = 'Modifier un produit';
    $view = 'update';
    require File::getApp(array("views","view.php"));
  }

  public static function updated(){
    $id = ($_POST['id']);
    $tag = ($_POST['tag']);
    $discount = ($_POST['discount']);
    $name = ($_POST['name']);
    $desc = ($_POST['description']);
    $price = ($_POST['price']);
    ModelProduct::update($id,$tag,$discount,$name,$desc,$price);
    ControllerProduct::readAll();
  }
}
?>
