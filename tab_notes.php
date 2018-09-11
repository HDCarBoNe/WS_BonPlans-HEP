<div class="table-responsive-sm">
  <table class="table">
    <thead>
        <tr><th><?php echo $_SESSION['nom_cat'] ?></th><th>Nom Devoir</th><th>Notes</th><th>Coef</th><th>Moyenne</th><th>Moyenne-Classe</th></tr>
    </thead>
    <tbody>
            <?php
            $req3=$bdd->prepare("SELECT COUNT(*) AS total  FROM notes WHERE id_categorie=:idcat AND id_utilisateur = :iduti");
            $req3->bindParam(':idcat', $_SESSION['id_cat']);
            $req3->bindParam(':iduti', $_SESSION['nomUtilisateur']);
            $req3->execute();
            $resultat=$req3->fetch();
            $req3->closecursor();
            $req4=$bdd->prepare("SELECT * FROM notes WHERE id_categorie=:idcat AND id_utilisateur = :iduti");
            $req4->bindParam(':idcat', $_SESSION['id_cat']);
            $req4->bindParam(':iduti', $_SESSION['nomUtilisateur']);
            $req4->execute();
            $affichage=$req4->fetchall();

            $req6=$bdd->prepare("SELECT * FROM notes WHERE id_categorie=:idcat");
            $req6->bindParam(':idcat', $_SESSION['id_cat']);
            $req6->execute();
            $allnote=$req6->fetchall();

            $taille_tableau = sizeof($affichage);
            $nbr_note=0;
            $moyenne_eleve = 0;
            $coef = 0;
            while ($nbr_note < $taille_tableau) {
                $moyenne_eleve += ($affichage[$nbr_note][3]*$affichage[$nbr_note][4]);
                $coef += $affichage[$nbr_note][4];
                $nbr_note++; 
            }
            $moyenne_eleve /= $coef;

            $tab_taille_classe = sizeof($allnote);
            $nbr_note_classe=0;
            $moyenne_classe = 0;
            $coef_classe = 0;
            while ($nbr_note_classe < $tab_taille_classe) {
                $moyenne_classe += ($allnote[$nbr_note_classe][3]*$allnote[$nbr_note_classe][4]);
                $coef_classe += $allnote[$nbr_note_classe][4];
                $nbr_note_classe++; 
            }
            $moyenne_classe /= $coef_classe; 

            $s=0;
            while ($s < $resultat['total']) {
                echo "<tr><th></th>";
                echo "<th>".$affichage[$s][2]."</th>";
                if($affichage[$s][3]<10){
                    echo "<td class='alert-danger'>".$affichage[$s][3]."</td>";
                   }
                else if($affichage[$s][3]>14){
                            echo "<td class='alert-success'>".$affichage[$s][3]."</td>";
                    }
                else if($affichage[$s][3]==10){
                             echo "<td class='alert-warning'>".$affichage[$s][3]."</td>";
                    }
                else if ($affichage[$s][3]>10 && $affichage[$s][3] <=14){
                        echo "<td class='table-Default'>".$affichage[$s][3]."</td>";
                    }
                echo "<th>".$affichage[$s][4]."</th>";
                if ($s == 0) {
                    echo "<th>".round($moyenne_eleve, 2)."</th>";
                    echo "<th>".round($moyenne_classe, 2)."</th>";
                }
                    echo "</tr>";
                    $s++;

            }
            ?>
    </thead>
</table>
</div>