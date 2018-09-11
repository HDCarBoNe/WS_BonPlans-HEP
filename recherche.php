<?php include_once('verif.php');
$page = basename(__FILE__);
$cate['total_cours'] = 0;
$resultat['total'] = 0;?>
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
                    <h1>Vous avez recherché les cours, <?php if(isset($_POST['search'])){echo "contenant le mots ".$_POST['search'];}else{echo "de la catégorie ".$_GET['search'];} ?></h1>
                        <?php
                            include_once "config.php";
                            $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME
                                           , Config::USER, Config::PASSWORD);
                            if(isset($_POST['search']) && $_POST['search'] != NULL)
                            {
                            $requete='%'.$_POST['search'].'%';
                            $req=$bdd->prepare("SELECT COUNT(*) AS total FROM cours WHERE nom_cours LIKE :requete");
                            $req->bindparam(':requete',$requete);
                            $req->execute();
                            $resultat=$req->fetch();
                            $req->closecursor();

                            if($resultat['total'] != 0)
                            {

                            $req=$bdd->prepare("SELECT nom_cours FROM cours WHERE nom_cours LIKE :requete");
                            $req->bindparam(':requete',$requete);
                            $req->execute();
                            $resultat2=$req->fetchall();
                            }
                            }

                            // Boucle de récupération des cours en fonction de l'id categorie

                            if(isset($_GET['search']) && $_GET['search'] != NULL)
                            {
                            $req2=$bdd->prepare("SELECT Id_categorie FROM categories WHERE libelle_categorie = :idcat");
                            $req2->bindparam(':idcat',$_GET['search']);
                            $req2->execute();
                            $cateID=$req2->fetch();
                            $req2->closecursor();

                            $req2=$bdd->prepare("SELECT COUNT(*) AS total_cours FROM cours WHERE libelle_categorie = :idcat");
                            $req2->bindparam(':idcat',$cateID[0]);
                            $req2->execute();
                            $cate=$req2->fetch();
                            $req2->closecursor();

                            if($cate['total_cours'] !=0){
                                $req2=$bdd->prepare("SELECT nom_cours FROM cours WHERE libelle_categorie = :idcat");
                                $req2->bindparam(':idcat',$cateID[0]);
                                $req2->execute();
                                $cate2=$req2->fetchall();
                            }
                            }

                            ?>

                            <table class="table table-striped">
                        <thead>
                            <tr>

                                <td>Categories</td>
                                <td>Nom du cours</td>
                                <td>Createur</td>
                                <td>Note</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            if($resultat['total'] != 0)
                                {

                                $req=$bdd->prepare("SELECT  libelle_categorie,nom_cours, identifiant, Notes FROM cours WHERE nom_cours LIKE :requete");
                                $req->bindparam(':requete',$requete);
                                $req->execute();
                                $resultat2=$req->fetchall();
                                $i=0;
                                    while ($i < $resultat['total']) {
                                        $req=$bdd->prepare("SELECT libelle_categorie FROM categories WHERE Id_categorie = :idcat");
                                        $req->bindparam(':idcat',$resultat2[$i][0]);
                                        $req->execute();
                                        $nom_cat=$req->fetch();
                                     echo"<tr><td>".$nom_cat[0]."</td>
                                         <td>".$resultat2[$i][1]."</td>
                                         <td>".$resultat2[$i][2]."</td>
                                         <td>".$resultat2[$i][3]."</td></tr>";
                                    $i++;
                                    }
                                }

                                if($cate['total_cours'] != 0)
                                {

                                $req4=$bdd->prepare("SELECT  libelle_categorie,nom_cours, identifiant, Notes FROM cours WHERE libelle_categorie = :idcat");
                                $req4->bindparam(':idcat',$cateID[0]);
                                $req4->execute();
                                $cate2=$req4->fetchall();
                                $i=0;
                                    while ($i < $cate['total_cours']) {
                                        $req=$bdd->prepare("SELECT libelle_categorie FROM categories WHERE Id_categorie = :idcat");
                                        $req->bindparam(':idcat',$cate2[$i][0]);
                                        $req->execute();
                                        $nom_cat=$req->fetch();
                                     echo"<tr><td>".$nom_cat[0]."</td>
                                         <td>".$cate2[$i][1]."</td>
                                         <td>".$cate2[$i][2]."</td>
                                         <td>".$cate2[$i][3]."</td></tr>";
                                    $i++;
                                    }
                                }
                                
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');?>
</body>
</html>