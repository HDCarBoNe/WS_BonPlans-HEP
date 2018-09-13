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
        <li class="nav-item">
          <a class="nav-link" href="index.php">Accueil
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bp.php">Bon Plans</a>
        </li>
        <?php
            $req2 = $bdd->prepare("SELECT TypeUtilisateur FROM utilisateurs WHERE idUtilisateur = :id");
            $req2->bindParam(":id",$_SESSION['id']);
            $req2->execute();
            $res = $req2->fetch();
            $droit = $res['TypeUtilisateur'];

            if (!isset($_SESSION['id'])) {
              echo '<li class="nav-item">
                <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#pro">Fait ta pub !</a>
              </li>';

              echo '<li class="nav-item">
                <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#connect">Se connecter</a>
              </li>';
            }
            if ($droit == 2) {
              echo '<li class="nav-item">
                <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a>
              </li>';

              echo '<li class="nav-item">
                <a href="profil.php?id='.$_SESSION["id"].'" class="nav-link">Profil</a>
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
                           <a href="#" class="dropdown-item add-project" data-toggle="modal" data-target="#add_news">Ajouter news</a>
                           <a href="#" class="dropdown-item add-project" data-toggle="modal" data-target="#list_propo">Liste propositions</a>
                          </div>
                        </li>';

              echo '<li class="nav-item">
                <a href="profil.php?id='.$_SESSION["id"].'" class="nav-link">Profil</a>
              </li>';

              echo '<li class="nav-item">
                <a href="deco.php" class="nav-link">Deconnexion</a>
              </li>';
            }
            if ($droit == 3) {
              echo '<li class="nav-item">
                <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a><a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_bp">Proposer Bon plan</a>
              </li>';

              echo '<li class="nav-item">
                <a href="#" class="add-project nav-link" data-toggle="modal" data-target="#add_offre">Proposer son offre </a>
              </li>';

              echo '<li class="nav-item">
                <a href="profil.php?id='.$_SESSION["id"].'" class="nav-link">Profil</a>
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
