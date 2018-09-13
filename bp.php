<?php
    session_start();
    include_once('config.php');
    $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
?>
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

  </head>

  <body>

    <!-- Navigation -->
    <?php include_once('nav.php'); ?>


    <!-- contenu -->
    <div class="container">

      <!-- Page bon plans -->
      <!-- Ordonnée les news par date la plus récente étant la première -->
      <div class="row text-center">

        <?php
        $req = $bdd->prepare("SELECT A.IdArticle, A.Titre, A.Texte, A.Date_article, U.Identifiant, U.IdUtilisateur FROM articles A, utilisateurs U WHERE U.IdUtilisateur = A.IdUtilisateur AND A.Type_article=0 ORDER BY A.Date_article");
        $req->execute();
        $data = $req->fetchall();

        $i=0;
        while (isset($data[$i][0])) {
          $resume = substr($data[$i][2],0,254);
          echo '<div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <img class="card-img-top" src="http://placehold.it/500x325" alt="">
            <div class="card-body">
            <h4 class="card-title">'.$data[$i][1].'</h4>
            <i class="card-author"> <a href="profil.php?id='.$data[$i][5].'">'.$data[$i][4].'</a></i>
            <p class="card-text">'.$resume.'</p>
            </div>
            <div class="card-footer">
              <a href="article.php?id='.$data[$i][0].'" class="btn btn-primary">Voir l\'article</a>
            </div>
          </div>
                </div>';
          $i++;
        }
         ?>
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
    <?php include_once('popup.php'); ?>
    <script src="css/jquery/jquery.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
