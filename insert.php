<?php

//insert.php

include_once('config.php'); 
    $connect = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD); 

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events 
 (title, start_event, end_event) 
 VALUES (:title, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'       => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event'   => $_POST['end']
  )
 );
}


?>

