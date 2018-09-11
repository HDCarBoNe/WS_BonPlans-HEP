<?php

//delete.php

if(isset($_POST["id"]))
{
include_once('config.php'); 
 $connect = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD); 
 $query = "DELETE from events WHERE id=:id";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>