<?php
    session_start();
    include_once('config.php');
    $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
?>
<!-- Faire les login de connection -->
<!-- rajouter les différents menu si l'utilisateur est connecter -->
<!-- boutton ajouter un news si l'utilisateur est modérateur -->
<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bon Plans- HEP</title>

    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript">
      $(document).ready(function(){
      $('[data-toggle="offcanvas"]').click(function(){
          $("#navigation").toggleClass("hidden-xs");
        });
      });
    </script>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Bon Plans  - HEP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Verif login -->
        <?php if (isset($_POST['login'])){
                    //  Récupération des données de l'utilisateur grace de son pass crypter
                    $req = $bdd->prepare("SELECT idUtilisateur, TypeUtilisateur FROM utilisateurs WHERE Identifiant = :login AND mdp = :mdp");
                    $req->bindParam(":login",$_POST['login']);
                    $req->bindParam(":mdp",$_POST['mdp']);
                    $req->execute();
                    $resultat = $req->fetch();
                    if (!$resultat)
                    {
                        echo '<div class="alert alert-danger" role="alert">Mauvais identifiant ou mot de passe !</div>';
                    }
                    else
                    {
                        $_SESSION['id'] = $resultat['idUtilisateur'];
                        echo '<script language="JavaScript" type="text/javascript">window.location.replace("index.php");</script>';
                    }
                } ?>
          <!-- fin verif login -->

       <!-- Faire des conditions pour rajouter des menus dans la barres des taches quand l'utilisateurs est connecter -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Accueil
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Bon Plans</a>
            </li>
            <?php
                $req2 = $bdd->prepare("SELECT TypeUtilisateur FROM utilisateurs WHERE idUtilisateur = :id");
                $req2->bindParam(":id",$_SESSION['id']);
                $req2->execute();
                $res = $req2->fetch();
                $droit = $res['TypeUtilisateur'];

                if (!isset($_SESSION['id'])) {
                  echo '<li class="nav-item">
                    <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#connect">Se connecter</a>
                  </li>';
                }
                if ($droit == 2) {
                  echo '<li class="nav-item">
                    <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="profil.php?id='.$_SESSION['id'].'" class="nav-link">Profil</a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="deco.php" class="nav-link">Deconnexion</a>
                  </li>';
                }
                if ($droit == 1) {
                  echo '<li class="nav-item">
                    <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a>
                  </li>';

                  echo '<li class="nav-item dropdown">
                             <a class="nav-link dropdown-toggle" href="#" id="navadmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
                             <div class="dropdown-menu" aria-labelledby="navadmin">
                               <a href="#" class="dropdown-item add-project" data-toggle="modal" data-target="#add_bp">Ajouter news</a>
                               <a href="#" class="dropdown-item add-project" data-toggle="modal" data-target="#add_bp">Liste propositions</a>
                             </div>
                            </li>';

                  echo '<li class="nav-item">
                    <a href="profil.php?id='.$_SESSION['id'].'" class="nav-link">Profil</a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="deco.php" class="nav-link">Deconnexion</a>
                  </li>';
                }
                if ($droit == 3) {
                  echo '<li class="nav-item">
                    <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer son offre </a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="profil.php?id='.$_SESSION['id'].'" class="nav-link">Profil</a>
                  </li>';

                  echo '<li class="nav-item">
                    <a href="deco.php" class="nav-link">Deconnexion</a>
                  </li>';
                }

            ?>
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
            </form>
          </ul>
        </div>

      </div>
    </nav>

    <!-- Contneu -->
    <div class="container">
      <!-- Jumbotron Header -->
      <header class="jumbotron my-4">
        <h1 class="display-3">Bon plans-HEP</h1>
        <p class="lead">Le site de partage de bon plans dans votre ville !</p>
        <a href="#" class="btn btn-primary btn-lg">En voir plus !</a>
      </header>

      <!-- Page News -->
      <!-- Ordonnée les news par date la plus récente étant la première -->
      <div class="row text-center">

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
              <h4 class="card-title">News 1</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
              <h4 class="card-title">News 2</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo magni sapiente, tempore debitis beatae culpa natus architecto.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
              <h4 class="card-title">News 3</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
              <h4 class="card-title">News 4</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo magni sapiente, tempore debitis beatae culpa natus architecto.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
              <h4 class="card-title">News 5</h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo magni sapiente, tempore debitis beatae culpa natus architecto.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-primary">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; WorskShop HEP 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <script src="css/jquery/jquery.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
  <!-- popup connection -->
  <div id="connect" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header login-header">
                  <h4 class="modal-title">Connecter vous !</h4>
                  <button type="button" class="close" data-dismiss="modal">×</button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="index.php">
                  <br>
                  <label for="login">Pseudo de connection :</label>
                  <input class="form-control" type="text" name="login" id="login" placeholder="Pseudo" required></input>
                  <br>
                  <label for="mdp">Mots de passe :</label>
                  <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Mots de passe" required></input>
                  <br>
                  <input class="btn btn-outline-primary" type="submit" value="se connecter" id="addCr2"/>
              </div>
          </div>
        </form>
      </div>
  </div>
  <!-- fin popup connection -->
</html>
