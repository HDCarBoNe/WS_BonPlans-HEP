    <div id="add_note" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <form method="post" action="noteinbdd.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Ajouter une note</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="noteinbdd.php">
                    
                    <br>
                                    <select class="form-control" name="categories">
                                    <?php
                                        include_once('config.php');
                                        $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD); 
                                        $req = $bdd->prepare("SELECT libelle_categorie,Id_categorie FROM categories");
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
                                
                    <input type="text" name="nom_devoir" id="Nom du devoir" placeholder="Nom du devoir" required></input>
                    <br>
                    <input type="integer" name="note" id="Notes" placeholder="Notes" required></input>
                    <br>
                    <input type="float" name="coef" id="Coef" placeholder="Coef" required></input>
                    <br>
                    <input type="submit" value="Ajouter" id="addCr2"/>
                   
                </div>
            </div>
          </form>
        </div>
    </div>