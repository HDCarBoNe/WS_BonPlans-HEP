<?php
include_once('config.php');
$date_now = date('Y-m-d');
echo $date_now;
echo $_POST['titre'];
echo $_POST['id_uti'];
echo $_POST['text-area'];

$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
$req = $bdd->prepare("INSERT INTO articles (Titre, IdUtilisateur, Texte, Date_article, Type_article) VALUES (:titre,:iduti,:texte,:dat, 2)");
$req->bindParam(":titre",$_POST['titre']);
$req->bindParam(":iduti",$_POST['id_uti']);
$req->bindParam(":texte",$_POST['text-area']);
$req->bindParam(":dat",$date_now);
$req->execute();
header('Location:index.php');
 ?>
