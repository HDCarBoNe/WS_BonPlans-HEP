<?php
      include_once 'config.php';
      $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME
               , Config::USER, Config::PASSWORD); 
$inscri=$_POST["mail"];
$tab=explode("@",$inscri);
$vérif="epsi.fr";
 for ($i=1; $i <2 ; $i++) { 
   if ($tab[$i]==$vérif) {
    $req=$bdd->prepare("INSERT INTO utilisateurs(Identifiant,Mots_de_passe,Email,Prenom,Nom,promotions) VALUES(:id, SHA(:mdp), :mail, :prenom, :nom, :promotions)");
    $req->bindParam(":id",$_POST["id"]);
    $req->bindParam(":mail",$_POST["mail"]);
    $req->bindParam(":mdp",$_POST["mdp"]);
    $req->bindParam(":nom",$_POST["nom"]);
    $req->bindParam(":prenom",$_POST["prenom"]);
    $req->bindParam(":promotions",$_POST["promotions"]);
    $req->execute();
    $bdd=null;
    header('Location:index.php');
   }
 }
?>