<?php include_once('verif.php');
$page = basename(__FILE__);
include_once 'config.php';
$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);?>
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
                    <h1>Vos notes, <?php echo $_SESSION['nomUtilisateur']?></h1>
                    <?php
                        $req=$bdd->prepare("SELECT DISTINCT id_categorie FROM notes ");
                        $req->execute();
                        $temp=$req->fetchALL();
                        $taille=sizeof($temp);
                        $i=0;
                        $nbr_cat = 0;
                                    while ($i< $taille) {
                                        $req2=$bdd->prepare("SELECT libelle_categorie FROM categories WHERE Id_categorie = :idcat");
                                        $req2->bindParam(":idcat", $temp[$i][0]);
                                        $req2->execute();
                                        $lib_cat=$req2->fetchALL();
                                        $_SESSION['nom_cat']=$lib_cat[0][0];
                                        $_SESSION['id_cat']=$temp[$i][0];
                                        include('tab_notes.php');
                                        $nbr_cat++;
                                        $i++;
                                    }

                                    ?>       
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');?>
</body>
</html>