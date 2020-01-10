<?php
require_once('api.php');


Class Items extends API {
  public function __construct(){
    parent::__construct();
    $this->table = 'items';
  }
  public function all() {
    $data = $this->db->select($this->table, '*');
    $this->returnJSON($data);
  }
  public function characterInventory($id, $silent = false){
    // select items.*, pc_inventory.qty from items left join pc_inventory on items.id = pc_inventory.item_id where pc_inventory.`pc_id` = 1
    $where = NULL;
    $what = "items.*, pc_inventory.qty, pc_inventory.equipped";
    $join = " LEFT JOIN pc_inventory on items.id = pc_inventory.item_id";
    $order = "items.name";
    $where = " pc_inventory.pc_id = $id";
    $inventory = $this->db->select('items', $what, $where, $join, $order);
    if($silent){
      return $inventory;
    } else {
      $this->returnJSON($inventory);
    }
  }
}
