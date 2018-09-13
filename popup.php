<?php session_start(); ?>
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
<!-- popup ajout bon plans -->
<div id="add_bp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <h4 class="modal-title">Partager votre bon plans !</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_bp.php">
                <br>
                <label for="titre">Titre de votre bon plan :</label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" required></input>
                <br>
                <label for="text-area">Expliquer nous votre bon plan :</label>
                <textarea class="form-control" name="text-area" id="text-area" rows="3" placeholder="Le lieu, les conditions du bon plan, les dates jusqu'au quel le bon plan sera disponible ... " required></textarea>
                <br>
                <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="id_uti"></input>
                <input class="btn btn-outline-primary" type="submit" value="Partager !" id="addCr2"/>
            </div>
        </div>
      </form>
    </div>
</div>
<!-- fin popup ajout bon plans -->
<!-- popup ajout news-->
<div id="add_news" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <h4 class="modal-title">Partager une News</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_news.php">
                <br>
                <label for="titre">Titre de votre news :</label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" required></input>
                <br>
                <label for="text-area">Détails de la news :</label>
                <textarea class="form-control" name="text-area" id="text-area" rows="3" placeholder="Le lieu, les conditions de la news, les dates concernant la news ... " required></textarea>
                <br>
                <label for="photo"> Ajouter une image</label>
                <input type="file" class="form-control-file" id="photo" name="photo"></input>
                <br>
                <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="id_uti"></input>
                <input class="btn btn-outline-primary" type="submit" value="Partager !" id="addCr2"/>
            </div>
        </div>
      </form>
    </div>
</div>
<!-- fin popup ajout news -->
<!-- popup ajout offre-->
<div id="add_offre" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <h4 class="modal-title">Faire votre offre</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_offre.php">
                <br>
                <small id="help" class="form-text text-muted">L'offre sera validé par un administrateur, elle vous permet de faire votre pub sur la page principal du site et tout ceci gratuitement :)</small>
                <label for="titre">Nom de votre offre :</label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" required></input>
                <br>
                <label for="text-area">Détails de votre offre :</label>
                <textarea class="form-control" name="text-area" id="text-area" rows="3" placeholder="Le lieu, les conditions de l'offre, la reduction/avantage de votre offre, les dates concernant la durée de l'offre ... " required></textarea>
                <br>
                <label for="photo"> Ajouter une image: (obligatoire)</label>
                <input type="file" class="form-control-file" id="photo" name="photo"></input>
                <br>
                <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="id_uti"></input>
                <input class="btn btn-outline-primary" type="submit" value="Partager !" id="addCr2"/>
            </div>
        </div>
      </form>
    </div>
</div>
<!-- fin popup ajout offre -->

<!-- popup liste offre-->
<div id="list_propo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <h4 class="modal-title">Liste de proposition d'offre:</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nom professionnel</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Aperçu</th>
                    <th scope="col">Valider/supprimer</th>
                  </tr>
                </thead>
                <?php
                $i = 0;
                $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
                $req3 = $bdd->prepare("SELECT A.Titre, A.IdArticle, U.Identifiant FROM articles A, utilisateurs U WHERE A.Type_article = 2 AND A.IdUtilisateur = U.IdUtilisateur");
                $req3->execute();
                $data = $req3->fetchall();
                echo "<tbody>";
                // var_dump($data);
                while (isset($data[$i][0])) {
                  echo '<tr>
                          <th scope="row">'.$data[$i][2].'</th>
                          <td>'.$data[$i][0].'</td>
                          <td><a href="news.php?id='.$data[$i][1].'">aperçu</a></td>
                          <td><a class="alert-success" href="accept.php?id='.$data[$i][1].'">Accepter</a>  <a class="alert-danger" href="refus.php?id='.$data[$i][1].'">Refuser</a></td>
                        </tr>';
                    $i++;
                }
                  echo "</tbody>
                    </table>";
                ?>

    </div>
</div>
<!-- fin popup liste offre -->
