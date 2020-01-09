<?php
require_once('api.php');


Class Race extends API {
  public function __construct(){
    parent::__construct();
    $this->table = 'races';
  }
  public function get($id = null) {
    $where = null;
    if ($id){
      if (is_numeric($id)) {
        $where = "id=$id";
      } else {
        $where = "name='$id'";
      }
    }
    $data = $this->db->select($this->table, '*', $where);
    if($id){
      $data = $data[0];
      $data->abilities = $this->getAbilities($id);
    }

    $this->returnJSON($data);
  }
  public function getbyid($id = null) {
    $where = "id=$name";
    $data = $this->db->select($this->table, '*', $where);
    $this->all = $data;
    $this->returnJSON($data);
  }
  private function getAbilities($id) {
    $where = "races.id=$id";
    $what = "abilities.*";
    $join = "LEFT JOIN race_abilities on abilities.id = race_abilities.ability_id";
    $join .=" LEFT JOIN races on race_abilities.race_id = races.id";
    $order = "abilities.name";
    $abilities = $this->db->select('abilities', $what, $where, $join, $order);
    return $abilities;
  }
}
?>
