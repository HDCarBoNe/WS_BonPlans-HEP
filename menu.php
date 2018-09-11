<div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a hef="room.html"><img src="tchat.png" alt="merkery_logo" class="hidden-xs hidden-sm">
                        <img src="tchat.png" alt="merkery_logo" class="visible-xs visible-sm circle-logo">
                    </a>
                </div>
                <!-- Barre Latéral de navigation --> 
                <div class="navi">
                    <ul>
                      <?php 
                        if ($page == 'accueil.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>
                        <a href="accueil.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Accueil</span></a></li>
                        
                        <?php 
                        if ($page == 'cours.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>
                        <a href="cours.php"><i class="fa fa-tasks" aria-hidden="true"></i><span class="hidden-xs hidden-sm"> Liste des cours</span></a></li>
                        
                        <?php
                        // $texte = htmlspecialchars($page);
                        // $all_page_acces = preg_match("#acceschat#i", "'.$texte.'"); 
                        if ($page == 'tchat.php' || $page == 'accestchat.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>
                        <a href="tchat.php"><i class="fa fa-comments-o" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Discuter entre étudiants</span></a></li>
                        
                        <?php 
                        if ($page == 'voirforum.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>

                        <a href="voirforum.php"><i class="fa fa-question-circle" aria-hidden="true"></i><span class="hidden-xs hidden-sm">F.A.Q</span></a></li>
                        
                        <?php 
                        if ($page == 'orga_soutien.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>

                        <a href="orga_soutien.php"><i class="fa fa-book" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Cours de soutien</span></a></li>
                        
                        <?php 
                        if ($page == 'notes.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>

                        <a href="notes.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Vos notes</span></a></li>
                        
                        <?php 
                        if ($page == 'profil.php' || $page == 'edit_profil.php') {
                            echo '<li class="active">';
                        }
                        else{
                            echo '<li>';
                        }
                      ?>

                        <a href="profil.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profil</span></a></li>
                    </ul>
                </div>
            </div>