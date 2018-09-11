<?php
//include_once('verif.php');
$page = basename(__FILE__);
include_once('config.php');?>
<!--  Faire upload cours
 faire systeme notation cours
 Faire Page pour téléchatger l'application
 Mettre icon logo dans l'onglet
 Modifier le logo du site par celui de la page de login
 Faire un champs de recherche pour les profils
 Faire les images F.A.Q
 Implémenter réponse FAQ
 Faire la limitations des étudiants sur le tchat
 Notification des invitations tchat
 Mettre image petit + avec les bouttons ajouter navbar
 Faire les liens pour acceder a la page du cours correcpondante
 Faire la page avec les cours liens de téléchargement description ect...
 Possibilité de supprimées message tchat et note
 Afficher les compétence sur les profils utilisateurs
 Faire une section de recherche d'aide qui renvoie les étudiants qui on des compétences dans tel domaine
 Ajout des notes par CSV pour une sessions prof -->

<html>
<head>
  <title>Antre Aide Tudiant</title>
    <?php include_once('header.php');?>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php include_once('menu.php');?>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                   <?php include_once('navbar_profil.php');?>
                <div class="user-dashboard">
                    <?php
                        $i=0;
                            $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
                            $req2=$bdd->prepare("SELECT (SUM(note*coef) / SUM(coef)) AS moyenne, notes.id_categorie, libelle_categorie FROM notes  JOIN categories ON notes.id_categorie = categories.Id_categorie WHERE id_utilisateur = :iduti GROUP BY notes.id_categorie HAVING moyenne<12 " );
                                $req2->bindparam(":iduti",$_SESSION['nomUtilisateur']);
                                  $req2->execute();
                                  $idcat=$req2->fetchALL();
                                  while(isset($idcat[$i][1])){
                                echo '<a href="recherche.php?search='.$idcat[$i][2].'"><div class="table-responsive-sm alert alert-danger" role="alert" name="idcat" id="div_alert_note">
                                <h4>Nous vous conseillons d\'étudier les cours de la catégorie '.$idcat[$i][2].'</h4></div></a>';
                          $i++;

                        }
                        ?>
                    <h1>Bienvenue, <?php echo $_SESSION['nomUtilisateur']?></h1>
                    <div class="row">
                        <div class="col-md-10 col-sm-5 col-xs-12 gutter">

                            <div class="cours">
                                <h2>Les nouveaux cours</h2>
                            </div>
                        </div>
                            <div class="col-md-10 col-sm-5 col-xs-12 gutter">
                                <?php
                                $recup=$bdd->prepare("SELECT nom_cours, cours.libelle_categorie, Identifiant, Notes FROM cours JOIN categories on categories.Id_categorie=cours.libelle_categorie ORDER BY cours.id_cour DESC LIMIT 5");
                                $recup->execute();
                                $data=$recup->fetchALL();
                                ?>
                                <table class="table table-responsive-sm table-hover">
                                    <thead class="thead-dark"><tr>
                                    <td>Categories</td>
                                    <td>Nom du cours</td>
                                </tr></thead>
                                <tbody>
                                    <?php
                                    $s=0;
                                    while ($s < 5) {
                                        $req=$bdd->prepare("SELECT libelle_categorie FROM categories WHERE Id_categorie = :idcat");
                                        $req->bindparam(':idcat',$data[$s][1]);
                                        $req->execute();
                                        $nom_cat=$req->fetch();
                                        echo '<tr><td>'.$nom_cat[0].'</td>';
                                        echo '<td>'.$data[$s][0].'</td>';
                                        echo "</tr>";
                                            $s++;
                                    }?>
                                </tbody>
                                </table><div>

                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');?>
</body>
</html>
