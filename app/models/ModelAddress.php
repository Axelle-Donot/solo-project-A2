<?php
require_once File::getApp(array("models", "Model.php"));

class ModelAddress extends Model {
  private $address_id;
  private $user_id;
  private $street;
  private $city;
  private $state;
  private $zip_code;
  private $country;
  private $supplement;

  protected static $object = "address";
  protected static $primary = "address_id";

  public function __construct($data = NULL) {
    if (!is_null($data)) {
      foreach ($data as $key => $valeur)
        $this->set($key, $valeur);
    }
  }

  // --- GETTERS ---

  public function get($nom_attribut) {
    if (property_exists($this, $nom_attribut))
      return $this->$nom_attribut;
    return false;
  }

  // --- SETTERS ---

  public function set($nom_attribut, $valeur) {
    if (property_exists($this, $nom_attribut))
      $this->$nom_attribut = $valeur;
    return false;
  }
}
