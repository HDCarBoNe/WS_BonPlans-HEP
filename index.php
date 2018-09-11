<?php
    session_start(); 
    include_once('config.php'); 
    $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME
               , Config::USER, Config::PASSWORD); 
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Connection</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="login.css"  type="text/css" rel="stylesheet">
        <link href="testbottstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="text-center" >
            <div class="card-img-overlay d-flex">
                <div class="my-auto mx-auto item-center" style="width: 300px;" >
                    <img src="logo_login.png">
                    <h2>Connectez-vous !</h2>
                    <form class="form-group" action="index.php" method="POST">
                        <br><input type="email" class="form-control" id="formGroupExampleInput" name="adr_mail" placeholder="Adresse Mail">
                            <input type="password" class="form-control" id="formGroupExampleInput" name="mdp" placeholder="Mot de Passe">
                        <br><button type="submit" class="btn btn-outline-dark" style="background-color: #C0C2C2;">Connexion</button>
                    </form>
                    <a href="inscription.php">Cliquer ici si vous n'êtes pas encore inscrit.</a>
                </div>
            </div>
    </body>
</html>
<?php
if (isset($_POST['adr_mail'])){
            //  Récupération des données de l'utilisateur grace de son pass crypter
            $req = $bdd->prepare("SELECT Identifiant,actif FROM utilisateurs WHERE Email = :adr_mail AND Mots_de_passe = SHA(:mdp)");
            $req->bindParam(":adr_mail",$_POST['adr_mail']);
            $req->bindParam(":mdp",$_POST['mdp']);
            $req->execute();
            $resultat = $req->fetch();
            if (!$resultat)
            {
                echo '<div class="alert alert-danger" role="alert">Mauvais identifiant ou mot de passe !</div>';
            }
            else
            {
                if($resultat['actif'] == 1){
                    $_SESSION['nomUtilisateur'] = $resultat['Identifiant'];
                    $_SESSION['email'] = $_POST['adr_mail'];
                    $_SESSION['connecte'] = 0;
                    echo '<script language="JavaScript" type="text/javascript">window.location.replace("accueil.php");</script>';

                }
                else{
                    echo '<div class="alert alert-danger" role="alert">Votre compte est désactivé !</div>';
                }
            }
        } ?>