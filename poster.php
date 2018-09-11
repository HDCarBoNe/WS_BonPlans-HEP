<?php
include_once('verif.php');
include_once('config.php');
$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME
               , Config::USER, Config::PASSWORD);

$today = getdate();
    $days=$today["year"]."-".$today["mon"]."-".$today["mday"]." ".$today["hours"].":".$today["minutes"].":".$today["seconds"].".0000";
    $post=$bdd->prepare("INSERT INTO reponses(Identifiant,message,date_time_reponse,Id_sujet) VALUES (:id,:message,:days,:Id_sujet)");
    
$post->bindparam(':message',$_POST['message']);
$post->bindparam(':id',$_SESSION['nomUtilisateur']);
$post->bindparam(':days',$days);
$post->bindparam(':Id_sujet',$_SESSION['Id_sujet']);
$post->execute();
//$reponse=$post->fetchAll();
//var_dump($reponse);
header('location:voirreponse.php?t='.$_SESSION['Id_sujet'].'');
$bdd=null;