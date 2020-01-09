<?php
Class API {
  public function __construct() {
    global $user;
    global $pass;
    global $database;
    $this->db = new Database($user, $pass, $database);
  }
  protected function returnJSON($data){
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
?>
