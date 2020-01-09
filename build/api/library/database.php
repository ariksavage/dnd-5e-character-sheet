<?php
class Database {
  public $debug;
  private $user;
  private $password;
  public $database;
  private $host;

  public function __construct($user, $pass, $database, $host = '127.0.0.1') {
    $this->user = $user;
    $this->password = $pass;
    $this->database = $database;
    $this->host = $host;
    if ($this->connect()){
      if ($this->debug){
        $this->status();
      }
      $this->disconnect();
    }
  }
  private function connect() {
    $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);

    if (!$this->conn) {
      echo "<p>Error: Unable to connect to MySQL.</p>".PHP_EOL;
      echo "<p>Debugging errno: " . mysqli_connect_errno()."</p>".PHP_EOL;
      echo "<p>Debugging error: " . mysqli_connect_error()."</p>".PHP_EOL;
      return false;
    } else {
      return true;
    }
  }

  private function disconnect() {
    mysqli_close($this->conn);
  }

  private function status() {
    echo "Success: A proper connection to MySQL was made! The $this->database database is great." . PHP_EOL;
    echo "Host information: " . mysqli_get_host_info($this->conn) . PHP_EOL;
  }

  private function query($q){
    if ($this->debug) {
      echo '<p>QUERY: '.$q.'</p>';
    }
    $this->connect();
    $result = $this->conn->query($q);
    $this->disconnect();
    return $result;
  }
  protected function type_value($value) {
    switch (TRUE) {
      case $value === null:
        return null;
        break;
      case $value === true:
      case $value === 'true':
        return true;
        break;
      case $value === false:
      case $value === 'false':
        return false;
        break;
      case is_numeric($value):
        return floatval($value);
        break;
      default:
        return $value;
        break;
    }
  }
  public function select($table, $what = '*', $where = null, $join = null, $order = null, $limit = null) {
    if (is_array($what)) {
      $what = implode(',', $what);
    }
    $q = "SELECT $what FROM $table";

    if ($join){
      $q .=" $join";
    }
    if ($where){
      $q .=" WHERE $where";
    }
    if ($order){
      $q .=" ORDER BY $order";
    }
    
    if ($result = $this->query($q)) {
      $rows = [];
      while ($obj = $result->fetch_object()) {
        foreach (get_object_vars($obj) as $key => $value) {
          $obj->$key = $this->type_value($value);
        }
        $rows[] = $obj;
      }
      $result->free_result();
      // return (count($rows) == 1)? $rows[0] : $rows;
      return $rows;
    }
    return false;
  }
}
?>
