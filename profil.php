<?php
session_start();
include_once('config.php');
$bdd = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);
?>

<html lang="fr">
    <head>
        <title>Profil</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="css/profil.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <?php

        $req = $bdd->prepare("SELECT TypeUtilisateur, Prenom, Nom, date_naissance, Etudes, Ville FROM profil P, utilisateurs U WHERE U.IdUtilisateur = P.IdUtilisateur AND U.IdUtilisateur= :id");
        $req->bindParam(":id", $_GET['id']);
        $req->execute();

        $resultat = $req->fetch();
        $Prenom = $resultat['Prenom'];
        $Nom = $resultat['Nom'];
        $Etude = $resultat['Etudes'];
        $Ville = $resultat['Ville'];
        $Birthdate = $resultat['Date_de_naissance'];
        // $Message = $resultat['Message_perso'];
        $Droit = $resultat['TypeUtilisateur'];

        $req2 = $bdd->prepare("SELECT Titre, Date, Likes FROM utilisateurs U, articles A, likes L WHERE A.IdUtilisateur=U.IdUtilisateur AND L.IdArticle=A.IdArticle AND U.IdUtilisateur=:id ORDER BY Date DESC");
        $req2->bindParam(":id", $_GET['id']);
        $req2->execute();
        $historique = $req2->fetchall();

        $req3 = $bdd->prepare("SELECT Likes FROM utilisateurs U, articles A, likes L WHERE A.IdUtilisateur=U.IdUtilisateur AND L.IdArticle=A.IdArticle AND U.IdUtilisateur=:id");
        $req3->bindParam(":id", $_GET['id']);
        $req3->execute();
        $historique_like = $req3->fetchall();

        $j = 0;
        $nb_likes = 0;
        while (isset($historique_like[$j])) {
            $nb_likes1 = current($historique_like[$j]);
            $nb_likes += $nb_likes1;
            $j++;
        }


        $req4 = $bdd->prepare("SELECT Dislikes FROM utilisateurs U, articles A, likes L WHERE A.IdUtilisateur=U.IdUtilisateur AND L.IdArticle=A.IdArticle AND U.IdUtilisateur=:id");
        $req4->bindParam(":id", $_GET['id']);
        $req4->execute();
        $historique_pourcent = $req4->fetchall();

        $k = 0;
        $nb_dislikes = 0;
        while (isset($historique_pourcent[$k])) {
            $nb_dislikes1 = current($historique_pourcent[$k]);
            $nb_dislikes += $nb_dislikes1;
            $k++;
        }
        $total = $nb_dislikes + $nb_likes;
        if ($total > 0) {
            $pourcentage = ($nb_likes / $total) * 100;
        } else {
            $pourcentage = 0;
        }


        $req5 = $bdd->prepare("SELECT COUNT(*) FROM articles WHERE IdUtilisateur=:id");
        $req5->bindParam(":id", $_GET['id']);
        $req5->execute();
        $nb_postes = $req5->fetch();
        $nb_postes=current($nb_postes);

        ?>
        <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="row panel">
                <div class="col-md-4 bg_blur ">

                </div>
                <div class="col-md-8  col-xs-12">
                    <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail picture hidden-xs" />
                    <img src="http://lorempixel.com/output/people-q-c-100-100-1.jpg" class="img-thumbnail visible-xs picture_mob" />
                    <div class="header">
                        <h1><?php echo $Prenom, " ", $Nom; ?></h1>
                        <h4><?php
        if ($Droit == 1) {
            echo "<p style='color:red'> Modérateur </p>";
        } elseif ($Droit == 2) {
            echo "Etudes: ", $Etude;
        } elseif ($Droit == 3) {
            echo "<p style='color:green'>", $Etude, "</p>";
        }
        ?></h4>

                        <h4>Ville: <?php echo $Ville; ?></h4>
                        <h4>Date de naissance: <?php echo $Birthdate; ?></h4>

                        <span>
                            <?php echo $Message; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row nav">
                <div class="col-md-4"></div>
                <div class="col-md-8 col-xs-12" style="margin: 0px;padding: 0px;">
                    <div class="col-md-4 col-xs-4 well"><i class="fa fa-weixin fa-lg"></i> <?php echo $nb_postes ?></div>
                    <div class="col-md-4 col-xs-4 well"><i class="fa fa-heart-o fa-lg"></i> <?php echo $pourcentage, "%"; ?></div>
                    <div class="col-md-4 col-xs-4 well"><i class="fa fa-thumbs-o-up fa-lg"></i> <?php echo $nb_likes; ?></div>
                </div>
            </div>
        </div>
        <div class="tableau" >
            <table class="table" style="color: black">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Date</th>
                        <th scope="col">Nombre de likes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;

                    while (isset($historique[$i])) {
                        $ligne = 1;
                        echo "<tr>
                        <th scope=", $i, ">$ligne</th>
                        <td>", $historique[$i][0], "</td>
                        <td>", $historique[$i][1], "</td>
                        <td>", $historique[$i][2], "</td>
                    </tr>";

                        $ligne++;
                        $i++;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </body>
</html>
