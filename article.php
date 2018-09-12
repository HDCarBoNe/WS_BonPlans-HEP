<?php
    session_start();
    include_once('config.php');
    $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
    $req = $bdd->prepare("SELECT A.Titre, A.Texte, A.Date_article, U.Identifiant FROM articles A, utilisateurs U WHERE U.IdUtilisateur = A.IdUtilisateur AND A.IdArticle= :id_article");
    $req->bindParam(":id_article",$_GET['id']);
    $req->execute();
    $data = $req->fetch();

    if(isset($_POST['commentaire'])){
      $date_now = date('Y-m-d');
      $req = $bdd->prepare("INSERT INTO commentaires(idArticle, idUtilisateur, text_com, date_com) VALUES(:idart, :iduti, :texte, :datecom)");
      $req->bindParam(":idart",$_GET['id']);
      $req->bindParam(":iduti",$_SESSION['id']);
      $req->bindParam(":texte",$_POST['commentaire']);
      $req->bindParam(":datecom",$date_now);
      $req->execute();
    }
?>
<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $data[0]; ?></title>
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/post.css" rel="stylesheet">
    <script type="text/javascript">
      $(document).ready(function(){
      $('[data-toggle="offcanvas"]').click(function(){
          $("#navigation").toggleClass("hidden-xs");
        });
      });
    </script>
  </head>

  <body>

    <?php include_once('nav.php'); ?>

    <!-- Contenu page  -->
    <div class="container">

      <div class="row">

        <!-- Proprieter du post-->
        <div class="col-lg-8">

          <!-- Titre -->
          <h1 class="mt-4"><?php echo $data[0]; ?></h1>

          <!-- Auteur -->
          <p class="lead">
            Publier par
            <a href="#"><?php echo $data[3]; ?></a>
          </p>

          <hr>

          <!-- Date -->
          <p><?php echo $data[2]; ?></p>

          <hr>

          <!-- Image-->
          <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

          <hr>

          <!--Contenu Post -->
          <?php echo $data[1]; ?>
          <hr>

          <!-- Commentaire -->
          <div class="card my-4">
            <h5 class="card-header">Commentaires:</h5>
            <div class="card-body">
              <?php echo '<form method="post" action="article.php?id='.$_GET['id'].'">'; ?>
                <div class="form-group">
                  <textarea class="form-control" name="commentaire" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
              </form>
            </div>
          </div>

          <!-- Les commentaires commentaire -->
          <?php
            $req5 = $bdd->prepare("SELECT C.text_com, U.Identifiant, U.IdUtilisateur FROM commentaires C, utilisateurs U WHERE C.idUtilisateur=U.IdUtilisateur ORDER BY date_com");
            $req5->execute();
            $comdata = $req5->fetchall();
            $j = 0;
            while (isset($comdata[$j][0])) {
              echo '<div class="media mb-4">
                      <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                      <div class="media-body">
                        <h5 class="mt-0"><a href="profil.php?id='.$comdata[$j][2].'">'.$comdata[$j][1].'</a></h5>
                        '.$comdata[$j][0].'
                      </div>
                    </div>';
                  $j++;
            }
           ?>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="#">Web Design</a>
                    </li>
                    <li>
                      <a href="#">HTML</a>
                    </li>
                    <li>
                      <a href="#">Freebies</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="#">JavaScript</a>
                    </li>
                    <li>
                      <a href="#">CSS</a>
                    </li>
                    <li>
                      <a href="#">Tutorials</a>
                    </li>
                  </ul>
                </div>
              </div>
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

    <!-- Bootstrap core JavaScript -->
    <script src="css/jquery/jquery.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
  <?php include_once('popup.php'); ?>
</html>
