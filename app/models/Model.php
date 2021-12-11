<?php
require_once File::getApp(array("lib", "Conf.php"));

class Model {
  private static $pdo;

  private static function Init() {
    $hostname = Conf::getHostname();
    $database_name = Conf::getDatabase();
    $login = Conf::getLogin();
    $password = Conf::getPassword();

    try {
      self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name;charset=utf8", $login, $password);
    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage(); // affiche un message d'erreur
      } else {
        echo "Une erreur est survenue <a href=\"\"> retour a la page d'accueil </a>";
      }
      die();
    }
  }

  public static function getPdo() {
    if (is_null(self::$pdo))
      Model::Init();
    return self::$pdo;
  }

  // -- CRUD Methods ---

  public static function selectAll() {
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);

    $sql = "SELECT * FROM `proj__" . $table_name . "`;";
    try {
      $db = self::getPdo();
      $rep = $db->query($sql);
      $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      $tab = $rep->fetchAll();

    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage();
      }
      return false;
    }

    return $tab ?? false;
  }

  public static function select($primaryValue) {
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);
    $pkey = static::$primary;

    $sql = "SELECT * FROM `proj__" . $table_name . "` WHERE `" . $pkey . "`=:tag;";
    try {

      $db = self::getPdo();
      $rep = $db->prepare($sql);
      $rep->execute(array("tag" => $primaryValue));
      $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      $el = $rep->fetch();
    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage();
      }
      return false;
    }

    return $el ?? false;
  }

  public static function delete($primaryValue){
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);
    $pkey = static::$primary;

    $sql = "DELETE FROM proj__" . $table_name . " WHERE " . $pkey . "=:tag";
    $db = self::getPdo();
    $rep = $db->prepare($sql);
    $rep->execute(array("tag" => $primaryValue));
  }

  public static function update($id, $tag,$discount,$name,$description,$price){
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);
    $pkey = static::$primary;

    $sql = "UPDATE  proj__" . $table_name . " SET " . "tag_id =" . ":tag," . "discount_id =" . ":discount," . 
    "name =" . ":name," . "description =" . ":description," . "price =" . ":price" . " WHERE " . "product_id=" . ":id;";

    try {

      $db = self::getPdo();
      $rep = $db->prepare($sql);
      $rep->execute(array("id" => $id, "tag" => $tag, "discount" => $discount, "name" => $name, "description" => $description, "price" => $price));
      $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      $el = $rep->fetch();
    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage();
      }
      return false;
    }

    return $el ?? false;
  }

  public static function create($tag,$discount,$name,$description,$price){
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);
    $pkey = static::$primary;

    $sql = "INSERT INTO proj__"  . $table_name . "(tag_id,discount_id,name,description,price)" . " VALUES " . "(:tag," . ":discount," . ":name," . ":description," . ":price)";


    try {

      $db = self::getPdo();
      $rep = $db->prepare($sql);
      $rep->execute(array("tag" => $tag, "discount" => $discount, "name" => $name, "description" => $description, "price" => $price));
      $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      $el = $rep->fetch();
    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage();
      }
      return false;
    }

    return $el ?? false;
  }

  public static function ajoutProduitPanier($primaryValue)
  {
    $table_name = static::$object;
    $class_name = "Model" . ucfirst($table_name);
    $pkey = static::$primary;   //cart_id
    

    //$sql = "INSERT INTO proj__" . $table_name . " VALUES " . "(1,":tag",1)";
    $sql = "SELECT * FROM proj_produit";
    try {

      $db = self::getPdo();
      $rep = $db->prepare($sql);
      $rep->execute(array("tag" => $primaryValue));
      $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      $el = $rep->fetch();
    } catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage();
      }
      return false;
    }

    return $el ?? false;
  }
}

