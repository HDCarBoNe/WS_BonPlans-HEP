<?php 
include_once('verif.php');
include_once('config.php');
$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);

                        echo $_POST["categories"];
                        $reqcat=$_POST["categories"];
                        $req=$bdd->prepare("SELECT id_categorie FROM categories WHERE libelle_categorie=:reqcat" );
                        $req->bindparam(':reqcat',$reqcat);
                        $req->execute();
                        $idcat=$req->fetchALL();

$ajout=$bdd->prepare("INSERT INTO notes(id_categorie,id_utilisateur,nom_devoir,note,coef) VALUES(:categorie,:nomUtilisateur,:nomdevoir,:note,:coef)");
$ajout->bindparam(':categorie',$idcat[0][0]);
$ajout->bindparam(':nomUtilisateur',$_SESSION['nomUtilisateur']);
$ajout->bindparam(':nomdevoir',$_POST['nom_devoir']);
$ajout->bindparam(':note',$_POST['note']);
$ajout->bindparam(':coef',$_POST['coef']);
$ajout->execute();
header('Location:notes.php');
$bdd=null;

?>