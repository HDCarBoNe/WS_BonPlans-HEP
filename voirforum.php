<?php include_once('verif.php');
$page = basename(__FILE__);?>
<html>
<head>
  <title>Antre Aide Tudiant</title>
    <?php include_once('header.php');?>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php include_once('menu.php');?>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                   <?php include_once('navbar_profil.php');?>
                <div class="user-dashboard">
                     <?php
        
			         include 'config.php';
			        $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);

					$titre="Voir un forum";   
					//A partir d'ici, on va compter le nombre de messages
					//pour n'afficher que les 25 premiers
					$query=$bdd->prepare('SELECT faq.Id_sujet, message_primaire, libelle_sujet, date, resolue, utilisateurs.Identifiant, Nom, Prenom FROM faq JOIN utilisateurs ON faq.Identifiant = utilisateurs.Identifiant GROUP BY faq.Id_sujet ORDER BY date DESC');
					$query->execute();
					$nbr=$bdd->prepare('SELECT COUNT(Id_sujet)as nbr_sujet FROM faq');
					$nbr->execute();
					$compteur_sujet=$nbr->fetch();

					//$data=$query->fetch();
					//var_dump($data);

					$totalDesMessages = $compteur_sujet['nbr_sujet'] ;
					$nombreDeMessagesParPage = 25;
					$nombreDePages = ceil($totalDesMessages / $nombreDeMessagesParPage);
					//echo '<p><i>Vous êtes ici</i> : <a href="./index.php">Index du forum</a> --> 
					//<a href="./voirforum.php?f='.$forum.'">'.stripslashes(htmlspecialchars($data['libelle_sujet'])).'</a>';
					//Nombre de pages


					$page = (isset($_GET['page']))?intval($_GET['page']):1;

					//On affiche les pages 1-2-3, etc.
					


					$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;

					//Le titre du forum
					echo '<h1>'.stripslashes(htmlspecialchars('F.A.Q. - Entre Aide Udiant')).'</h1><br /><br />';
						echo '<p>Page : ';
					for ($i = 1 ; $i <= $nombreDePages ; $i++)
					{
					    if ($i == $page) //On ne met pas de lien sur la page actuelle
					    {
					    echo $i;
					    }
					    else
					    {
					    echo '
					    <a href="voirforum.php?f='.$forum.'&amp;page='.$i.'">'.$i.'</a>';
					    }
					}
					echo '</p>';
					//Et le bouton pour poster
					//echo'<a href="./poster.php?action=nouveautopic&amp;f='.$forum.'">
					//<img src="./images/nouveau.gif" alt="Nouveau topic" title="Poster un nouveau topic" /></a>';
					?>  
						<a href="#" class="add-subject btn btn-info" data-toggle="modal" data-target="#add_subject">Poser une question</a>
					        <div id="add_subject" class="modal fade in" style="display: none" role="dialog" aria-hidden="false"><div class="modal-backdrop fade in"></div>
					        <div class="modal-dialog">
					            <form method="POST" action="ajout_sujet.php" enctype="multipart/form-data">
					            <div class="modal-content">
					                <div class="modal-header login-header">
					                    <button type="button" class="close" data-dismiss="modal">×</button>
					                    <h4 class="modal-title">Poser une question</h4>
					                </div>
					                <div class="modal-body">
					                    <input type="text" placeholder="Question" name="nom">              </select>
					                    <textarea placeholder="Description" name="message_primaire"></textarea>
					                    <input type="submit" value="sauvegarder"> 
					                </div>
					                
					            </div>
					          </form>
					        </div>
					    </div>
					<!--    <form method="POST" action="voirforum.php">
					        <br>

					        <input type="text" name="nom" id="Nom" placeholder="Nom" required></input>
					        <br>
					        <input type="text" name="message_primaire" id="message_primaire" placeholder="message_primaire" required></input>
					        <br>0
					        <input type="submit" value="Ajouter" id="addCr2"/>
					    </form>-->

					<?php
					//requete pour inserer un topic

					//On prend tout ce qu'on a sur les Annonces du forum
					       
					//On lance notre tableau seulement s'il y a des requêtes !
					if ($query->rowCount()>0)
					{
					        ?>
					        <table class="table table-striped">   
					        <tr>
					        <th><img src="./images/annonce.gif" alt="Annonce" /></th>
					        <th class="titre"><strong>Titre</strong></th>             
					        <th class="nombremessages"><strong>Réponses</strong></th>
					<!--        <th class="nombrevu"><strong>Vus</strong></th>-->
					        <th class="auteur"><strong>Auteur</strong></th>                       
					        <th class="meilleurmessage"><strong>Résolue</strong></th>
					        </tr>   
					       
					        <?php
					            //$req=$bdd->prepare("SELECT Id_sujet, COUNT(id_reponse)as nbr_reponse FROM reponses GROUP BY Id_sujet");
					            //$req->execute();
					            //$compteur_reponse= $req->fetchAll();
					            //var_dump($compteur_reponse);
					            
					            //$dernier->execute();
					            //$dernier_posteur = $dernier->fetch();
					           // var_dump($dernier_posteur);
					        //On commence la boucle
					        while ($data=$query->fetch()){
					            $Id_sujet = $data['Id_sujet'];
					            
					            $req=$bdd->prepare("SELECT COUNT(id_reponse)as nbr_reponse FROM reponses WHERE Id_sujet='$Id_sujet'");
					            $req->execute();
					            $compteur_message=$req->fetch();
					                //Pour chaque topic :
					                //Si le topic est une annonce on l'affiche en haut
					                //mega echo de bourrain pour tout remplir
					               
					                echo'<tr><td><img src="./images/message.gif" alt="Message" /> <br>A '.date('H\hi \l\e d M y', strtotime($data['date'])).'<br> '.nl2br(stripslashes(htmlspecialchars($data['message_primaire']))).'</td>

					                <td class="titre">
					                <strong><a href="./voirreponse.php?t='.$data['Id_sujet'].'"                 
					                title="Le sujet commencé à
					                '.date('H\hi \l\e d M y', strtotime($data['date'])).'">
					                '.stripslashes(htmlspecialchars($data['libelle_sujet'])).'</a></strong></td>
					                    
					                <td class="nombremessages">'.$compteur_message['nbr_reponse'].'</td>

					                <td><a href="./profil.php?utilisateurs='.$data['Identifiant'].'">
					                '.stripslashes(htmlspecialchars($data['Identifiant'])).'</a></td>
					                
					                <td class="resolue">'.$data['resolue'].'</td></tr>';
					                
					               	//Selection dernier message
							$nombreDeMessagesParPage = 15;
							$nbr_reponse = $compteur_sujet['nbr_sujet'] +1;
							$page = ceil($nbr_reponse / $nombreDeMessagesParPage);

					//                echo '<td class="resolue">Par
					//                <a href="./voirprofil.php?m='.$data['resolue'].'
					//                &amp;action=consulter">
					//                '.stripslashes(htmlspecialchars($dernier_posteur['Identifiant'])).'</a><br>
					//                 <td>'.$dernier_posteur['message'].'</td>
					//                A <a href="./voirreponse.php?t='.$data['Id_sujet'].'&amp;page='.$page.'#p_'.$dernier_posteur['Id_reponse'].'">'.date('H\hi \l\e d M y', strtotime($dernier_posteur['date_time_reponse'])).'</a></td></tr>';

					        }
					        ?>
					        </table>
					        <?php
					}
					else //S'il n'y a pas de message
					{
					        echo'<p>Ce forum ne contient aucun sujet actuellement</p>';
					}
					$query->CloseCursor();
					?>                       
                </div>
            </div>
        </div>
    </div>
<?php include_once('add_projet.php');?>
</body>
</html>