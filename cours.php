<?php include_once('verif.php');
$page = basename(__FILE__); ?>
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
                    <h1>Liste des cours</h1>
                 <div class="col-md-10 col-sm-5 col-xs-12 gutter">
                    <table class="table table-striped">
                        <thead>
                          <?php
                            include_once('config.php');
                            $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);

                            $req1=$bdd->prepare("SELECT COUNT(nom_cours) AS total FROM cours ORDER BY libelle_categorie");
                            $req1->execute();
                            $resultat=$req1->fetch();

                            $req=$bdd->prepare("SELECT nom_cours, categories.libelle_categorie, Identifiant, Notes, id_cour FROM cours JOIN categories on categories.Id_categorie=cours.libelle_categorie ORDER BY cours.libelle_categorie");
                            $req->execute();
                            $recup=$req->fetchALL();

                             $s=0;?>
                            <tr>
                                <td>Categories</td>
                                <td>Nom du cours</td>
                                <td>Createur</td>
                                <td>Note</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                while ($s < $resultat['total']) {
                
                                    echo '<tr><td>'.$recup[$s][1].'</td>';
                                    echo '<td><a href="cours_desc.php?id_cours='.$recup[$s][4].'">'.$recup[$s][0].'</a></td>';
                                    echo '<td>'.$recup[$s][2].'</td>';
                                    echo '<td>'.$recup[$s][3].'</td>';
                                    echo "</tr>";
                                        $s++;
                                }?>
                        </tbody>
                    </table>
                 </div>
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');?>
</body>
</html>

 echo "<tr><th>catégorie</th><td>nom_cours</td></tr>";
            while ($s < $resultat['total']) {
                
                echo '<tr><td>'.$recup[$s][1].'</td>';
                echo '<td>'.$recup[$s][0].'</td>';
                echo "</tr>";
                    $s++;
            }
?>