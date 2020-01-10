<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$database = 'dnd_db';
$user = 'dungeon_master';
$pass = 'jf54gSDG447';

require_once('./library/database.php');
require_once('./library/api.php');

require_once('./library/race.php');
require_once('./library/character.php');
require_once('./library/job.php');
require_once('./library/items.php');

$db = new Database($user, $pass, $database);
$db->debug = false;

function globalVar($name){
  global $_GET;
  $var = null;
  if(isset($_GET[$name])){
    $var = str_replace('/', '', $_GET[$name]);
  }
  return $var;
}
$type = globalVar('type');
$action = globalVar('action');
$param = globalVar('param');

if(class_exists($type)){
  $api = new $type();
  if(method_exists($api, $action)){
    $api->$action($param); 
  } else {
    echo "ERROR: $action is not a valid action";
  }
} else {
  echo "ERROR: $type is not a valid type";
}
?>
