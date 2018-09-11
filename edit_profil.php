<?php include_once('verif.php');
$page = basename(__FILE__);
$utilisateurs = $_SESSION['nomUtilisateur'];
include_once('config.php');
$redirection = 0;
$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
if (isset ($_POST['nom'])) {
    if ($_POST['nom'] != $resultat['nom']) {
        $modif_nom = $bdd->prepare('UPDATE utilisateurs SET Nom = :nom WHERE Identifiant = :id');
        $modif_nom->bindParam(":id",$utilisateurs);
        $modif_nom->bindParam(":nom",$_POST['nom']);
        $modif_nom->execute();
        $redirection = 1;
    }
}

if (isset($_POST['prenom']) && $_POST['prenom'] != $resultat['prenom']) {
    $modif_prenom = $bdd->prepare('UPDATE utilisateurs SET Prenom = :prenom WHERE Identifiant = :id');
    $modif_prenom->bindParam(":id",$utilisateurs);
    $modif_prenom->bindParam(":prenom",$_POST['prenom']);
    $modif_prenom->execute();
    $redirection = 1;
}

if (isset($_POST['promo']) && $_POST['promo'] != $resultat['promotions']) {
    $modif_nom = $bdd->prepare('UPDATE utilisateurs SET promotions = :promo WHERE Identifiant = :id');
    $modif_nom->bindParam(":id",$utilisateurs);
    $modif_nom->bindParam(":promo",$_POST['promo']);
    $modif_nom->execute();
    $redirection = 1;
}

if (isset($_POST['bio']) && $_POST['bio'] != $resultat['Commentaire_perso']) {
    $modif_nom = $bdd->prepare('UPDATE utilisateurs SET Commentaire_perso = :bio WHERE Identifiant = :id');
    $modif_nom->bindParam(":id",$utilisateurs);
    $modif_nom->bindParam(":bio",$_POST['bio']);
    $modif_nom->execute();
    $redirection = 1;
}

if ($redirection == 1) {
    echo '<script language="JavaScript" type="text/javascript">window.location.replace("profil.php");</script>';
}
?>

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
                    $req = $bdd->prepare("SELECT Email, Nom, Prenom, Commentaire_perso, promotions FROM utilisateurs WHERE Identifiant = :utilisateurs");
                    $req->bindParam(":utilisateurs",$utilisateurs);
                    $req->execute();
                    $resultat = $req->fetch();
                    ?><div class="container">
                        <div class="row">
                            <h1>Vous éditer votre Profil, <?php echo $resultat[1]." ".$resultat[2]?></h1>
                          <div class="col-md-7 ">
                    <div class="panel panel-default">
                      <div class="panel-heading">  <h4 >Profil utilisateur</h4> 
                      </div>
                    <div class="panel-body">
                      <div class="box box-info">
                        <div class="box-body">
                            <div class="col-sm-6">
                                <div  align="center"> <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-circle img-responsive">         
                                  <input id="profile-image-upload" class="hidden" type="file">
                                  <div style="color:#999;" >Cliquer sur l'image pour la changer</div>
                                    <!-- upload image -->
                                </div><br>
                            </div>
                            <form action="edit_profil.php" method="post">
                                <div class="col-sm-6">
                                  <h4 style="color:#00b1b1;"><?php echo $resultat['Nom']." ".$resultat['Prenom'];?> </h4></span>
                                    <span><p>Etudiant</p></span>            
                                </div>
                                <div class="clearfix"></div>
                                  <hr style="margin:5px 0 5px 0;">
                                  <div class="col-sm-5 col-xs-6 tital " >Nom:</div><div class="col-sm-7 col-xs-6 "><input type="text" name="nom" placeholder="<?php echo $resultat['Nom'];?>"></div>
                                    <div class="clearfix"></div>
                                  <div class="bot-border"></div>

                                  <div class="col-sm-5 col-xs-6 tital " >Prenom:</div><div class="col-sm-7"><input type="text" name="prenom" placeholder="<?php echo $resultat['Prenom'];?>"></div>
                                    <div class="clearfix"></div>
                                  <div class="bot-border"></div>

                                  <div class="col-sm-5 col-xs-6 tital " >Email:</div><div class="col-sm-7"><?php echo $resultat['Email'];?></div>
                                    <div class="clearfix"></div>
                                  <div class="bot-border"></div>

                                  <div class="col-sm-5 col-xs-6 tital " >Promotions:</div><div class="col-sm-7"><input type="number" name="promo" placeholder="<?php echo $resultat['promotions'];?>"></div>
                                    <div class="clearfix"></div>
                                  <div class="bot-border"></div>

                                  <div class="col-sm-5 col-xs-6 tital " >Bio:</div><div class="col-sm-7"><input type="text" name="bio" placeholder="<?php echo $resultat['Commentaire_perso'];?>"></div>

                                  <div class="col-sm-5 col-xs-6 tital"><button type="input" class="btn btn-info">Modifier</button></div>
                            </form>
                                <div class="clearfix"></div>
                              <div class="bot-border"></div>
                              <div class="col-sm-5 col-xs-6 tital " >Compétences:</div><div class="col-sm-7">
                        <?php 
                          $req = $bdd->prepare("SELECT DISTINCT id_categorie, note FROM competences WHERE id_utilisateur = :uti");
                                    $req->bindParam(":uti",$utilisateurs);
                                    $req->execute();
                                    $tab_comp = $req->fetchall();
                                    echo '<table class="table table-striped"><thead><tr><td>Catégorie</td><td>Compétences</td></tr></thead><tbody>';
                                    $i = 0;
                                    while (isset($tab_comp[$i])) {
                                      echo '<tr><td>';
                                      $req = $bdd->prepare("SELECT libelle_categorie FROM categories WHERE id_categorie = :idca");
                                      $req->bindParam(":idca",$tab_comp[$i][0]);
                                      $req->execute();
                                      $nom_cat = $req->fetch();
                                      echo $nom_cat[0].'</td><td>';
                                      if ($tab_comp[$i][1] == 0) {
                                        echo '<i class="fa fa-smile-o" aria-hidden="true"></i></td></tr>';
                                      }
                                      elseif ($tab_comp[$i][1] == 1) {
                                        echo '<i class="fa fa-meh-o" aria-hidden="true"></i></td></tr>';
                                      }
                                      elseif ($tab_comp[$i][1] == 2) {
                                        echo '<i class="fa fa-frown-o" aria-hidden="true"></i></td></tr>';
                                      }
                                      else{
                                        echo '<i class="fa fa-question-circle-o" aria-hidden="true"></i></td></tr>';
                                      }
                                      $i++;
                                    }
                                    ?>
                                  </div>
                              </div>
                            </div>
                          </div> 
                        </div>
                    </div>  
                    <script>
                      $(function() {
                        $('#profile-image1').on('click', function() {
                            $('#profile-image-upload').click();
                        });
                      });       
                    </script>     
                       </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');
?>
</body>
</html>