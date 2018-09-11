    <div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <form method="post" action="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Ajouter un cours</h4>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Nom du cours" name="nom">
                    <select class="form-control" name="categories">
                        <?php
                            include_once('config.php');
                            $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD); 
                            $req = $bdd->prepare("SELECT libelle_categorie FROM categories");
                            $req->execute();
                            $resultat = $req->fetchall();
                            $i=0;

                            while (isset($resultat[$i][0])) {
                                echo "<option>".$resultat[$i][0]."</option>";
                                $i ++;
                            }
                            $i=null;
                        ?>
                    </select>
                    <textarea placeholder="Description" name="descri"></textarea>
                    <div class="form-group">
                      <label for="exampleInputFile">Ajout du cours</label>
                      <input type="file" id="exampleInputFile" accept=".pdf">
                      <p class="help-block">Ajouter seulement un fichier au format pdf.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-dismiss="modal">Quitter</button>
                    <button type="submit" class="add-project" data-dismiss="modal">Sauvegarder</button>
                </div>
            </div>
          </form>
        </div>
    </div>
<?php include_once('add_note.php'); ?>