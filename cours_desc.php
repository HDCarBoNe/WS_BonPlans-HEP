<?php include_once('verif.php');
$page = basename(__FILE__);
include_once('config.php');
if(isset($_GET['id_cours'])){
  $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
  $req=$bdd->prepare("SELECT nom_cours, Adresse_pdf, commentaire_cours, Identifiant, categories.libelle_categorie FROM cours  JOIN categories ON cours.libelle_categorie = categories.Id_categorie WHERE id_cour = :idcour" );
  $req->bindparam(":idcour",$_GET['id_cours']);
    $req->execute();
    $cours_desc=$req->fetch();
    $nom_cours = $cours_desc[0];
    $adr_pdf = $cours_desc[1];
    $com_cours = $cours_desc[2];
    $nom_crea = $cours_desc[3];
    $nom_cate = $cours_desc[4];
}
else{
  header('Location: accueil.php');
}
?>
<html>
<head>
  <title>Entre Aide Udiant</title>
    <?php include_once('header.php');?>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php include_once('menu.php');?>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                   <?php include_once('navbar_profil.php');?>
                <div class="user-dashboard">
                  <div class="container">
                  <div class="resume">
                      <header class="page-header">

                      <h1 class="page-title"><?php echo $nom_cours;?></h1>
                    </header>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                      <div class="panel panel-default">
                        <div class="panel-heading resume-heading">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="col-xs-12 col-sm-4">
                                <figure>
                                  <!-- mettre image correspondant a la catégorie -->
                                  <?php include_once('img_cat.php');?> 
                                </figure>
                                
                                <div class="row">
                                  <div class="col-xs-12 social-btns">
                                    
                                      <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                        <!-- Mettre le système de rate -->
                                      </div>
                                  </div>
                                </div>
                                
                              </div>

                              <div class="col-xs-12 col-sm-8">
                                <ul class="list-group">
                                  <li class="list-group-item"><i class="fa fa-bookmark"></i><?php echo "  ".$nom_cours;?></li>
                                  <li class="list-group-item"><i class="fa fa-graduation-cap"></i><?php echo "  ".$nom_cate;?></li>
                                  <li class="list-group-item"><i class="fa fa-user"></i><a href="profil.php?utilisateurs=<?php echo $nom_crea;?>"><?php echo "  ".$nom_crea;?></a></li>
                                  <li class="list-group-item"><i class="fa fa-comment"></i><?php if(isset($com_cours)){echo "  ".$com_cours;}else{echo "  La personne qui a partagé n'as pas indiqué de description";}?></li>
                                  <li class="list-group-item"><i class="fa fa-cloud-download"></i> <a href="upload/<?php echo $adr_pdf;?>">  Lien de téléchargement</a></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
                </div>
            </div>
<?php include_once('add_projet.php');?>
</body>
</html>