<?php

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'tut');


function get_db(){
  try{
    $db = new PDO( 'mysql:host=' . HOST  . '; dbname=' . DBNAME . ';charset=utf8', USERNAME, PASSWORD );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
  }catch(PDOExecption $e){
    echo 'Connection Failed: ' . $e->getMessage();
  }
}

function get_map_data(){
  try{
    $db=get_db();
    $stmt = $db->query("SELECT name, lat, lon, description FROM locations");
    $data = $stmt->fetchAll();
    return json_encode($data);
  }catch(PDOExecption $e){
    return 'Error: ' . $e->getMessage();
  }
}


?>
