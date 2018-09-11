<?php include_once('verif.php');
$page = basename(__FILE__);
include_once('config.php');
if(isset($_GET['t'])){
}
else{
  header('Location: accueil.php');
}
?>
<html>
<head>
  <title>Entre Aide Udiant</title>
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
                        $titre="Voir un forum";
                    ?><a href="#" class="add-subject" data-toggle="modal" data-target="#add_answer">Répondre</a>

                            <?php
                            
                    $_SESSION['nomUtilisateur'];
                            $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME
                                   , Config::USER, Config::PASSWORD);
                            //On récupère la valeur de t
                    $Id_sujet = (int) $_GET['t'];
                     $_SESSION['Id_sujet']=$Id_sujet;
                    //A partir d'ici, on va compter le nombre de messages pour n'afficher que les 15 premiers
                    $query=$bdd->prepare("SELECT id_reponse, photo,message,date_time_reponse,note_reponse,reponses.Id_sujet, reponses.Identifiant, Nom, Prenom, email, promotion FROM reponses JOIN faq ON reponses.Id_sujet = faq.Id_sujet JOIN utilisateurs ON reponses.Identifiant=utilisateurs.Identifiant WHERE faq.Id_sujet=:idsujet ORDER BY date_time_reponse DESC");
                    $query->bindparam(':idsujet',$Id_sujet);
                    $query->execute();

                    $compteur=$bdd->prepare("SELECT COUNT(id_reponse)as nbr_reponse FROM reponses WHERE Id_sujet=:idsujet");
                    $compteur->bindparam(':idsujet',$Id_sujet);
                    $compteur->execute();
                    $compteur_reponse=$compteur->fetch();

                    $titre=$bdd->prepare("SELECT libelle_sujet, Id_sujet FROM faq WHERE Id_sujet=:idsujet'");
                    $titre->bindparam(':idsujet',$Id_sujet);
                    $titre->execute();
                    $titre_sujet=$titre->fetch();

                    $meilleur=$bdd->prepare("SELECT id_reponse, photo, message,date_time_reponse,note_reponse,reponses.Id_sujet, reponses.Identifiant, Nom, Prenom, email, promotion FROM reponses JOIN faq ON reponses.Id_sujet = faq.Id_sujet JOIN utilisateurs ON reponses.Identifiant=utilisateurs.Identifiant WHERE faq.Id_sujet=:idsujet ORDER BY note_reponse DESC LIMIT 1");
                    $meilleur->bindparam(':idsujet',$Id_sujet);
                    $meilleur->execute();
                    $meilleur_reponse=$meilleur->fetch();

                    $primaire=$bdd->prepare("SELECT photo, message_primaire,date, Id_sujet, faq.Identifiant, Nom, Prenom, email, promotion FROM faq JOIN utilisateurs ON utilisateurs.Identifiant=faq.Identifiant WHERE faq.Id_sujet=:idsujet ORDER BY Id_sujet");
                    $primaire->bindparam(':idsujet',$Id_sujet);
                    $primaire->execute();
                    $message_primaire=$primaire->fetch();

                    $totalDesMessages = $compteur_reponse['nbr_reponse'] + 1;
                    $nombreDeMessagesParPage = 15;
                    $nombreDePages = ceil($totalDesMessages / $nombreDeMessagesParPage);

                    echo '<p><a href="./voirforum.php"> Retour Aux Questions</a>';
                    echo '<h1>'.stripslashes(htmlspecialchars($titre_sujet['libelle_sujet'])).'</h1><br /><br />';
                     
                    //Nombre de pages
                    $page = (isset($_GET['page']))?intval($_GET['page']):1;

                    //On affiche les pages 1-2-3 etc...
                    echo '<p>Page : ';
                    for ($i = 1 ; $i <= $nombreDePages ; $i++)
                    {
                        if ($i == $page) //On affiche pas la page actuelle en lien
                        {
                        echo $i;
                        }
                        else
                        {
                        echo '<a href="voirtopic.php?t='.$Id_sujet.'&page='.$i.'">
                        ' . $i . '</a> ';
                        }
                    }
                    echo'</p>';
                     
                    $premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;

                         ?>   <div id="add_answer" class="modal fade in" style="display: none" role="dialog" aria-hidden="false"><div class="modal-backdrop fade in"></div>
                            <div class="modal-dialog">
                                <form method="POST" action="poster.php" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header login-header">
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                        <h4 class="modal-title">Votre réponse</h4>
                                    </div>
                                    <div class="modal-body">
                                        <textarea placeholder="Votre Réponse..." name="message"></textarea>
                                        <input type="submit" value="sauvegarder">
                                    </div>
                                    
                                </div>
                              </form>
                            </div>
                        </div>


                     <table><?php
                       echo'<tr><td><strong>
                             <a href="./voirprofil.php?m='.$message_primaire['Identifiant'].'&amp;action=consulter">
                             '.stripslashes(htmlspecialchars($message_primaire['Identifiant'])).'</a></strong></td>';//Lien vers profil
                            if ($_SESSION['nomUtilisateur'] == $message_primaire['Identifiant'])
                             {
                             echo'<td id=p_'.$message_primaire['Id_sujet'].'>Posté à '.date('H\hi \l\e d M y', strtotime($message_primaire['date'])).'
                             <a href="./poster.php?p='.$message_primaire['Id_sujet'].'&amp;action=delete">
                               
                             <a href="./poster.php?p='.$message_primaire['Id_sujet'].'&amp;action=edit">
                             <img src="./images/editer.gif" alt="Editer"
                             title="Editer ce message" /></a></td></tr>';
                             }
                             else
                             {
                             echo'<td>
                             Posté à '.date('H\hi \l\e d M y', strtotime($message_primaire['date'])).'
                             </td></tr>';
                             } 
                              //image relier avec bdd
                                 echo'<tr><td>
                             <img id="profil" src="./images/'.$message_primaire['photo'].'" alt="profil" />';
                            
                                     if($message_primaire['promotion']==1){
                                        echo'Promotion : '.stripslashes(htmlspecialchars($message_primaire['promotion'])).'ere année</td><br>'; 
                                     }else{
                                        echo'Promotion : '.stripslashes(htmlspecialchars($message_primaire['promotion'])).'eme année</td><br>';
                                   }
                             //Message
                             echo'<td>'.nl2br(stripslashes(htmlspecialchars($message_primaire['message_primaire']))).'
                             <br /><hr /></td></tr>';
                            if ($query->rowCount()<1)
                            {
                            echo'<p>Il n y a aucune réponse à cette question.</p>';}
                    //Si tout roule on affiche notre tableau puis on remplit avec une boucle
                            else{ ?></table><table>
                            <tr>
                            <th class="vt_auteur"><strong>Auteurs</strong></th>             
                            <th class="vt_mess"><strong>Messages</strong></th>       
                            </tr>
                            <?php
                            echo'<tr><td><strong>
                             <a href="./voirprofil.php?m='.$meilleur_reponse['Identifiant'].'&amp;action=consulter">
                             '.stripslashes(htmlspecialchars($meilleur_reponse['Identifiant'])).'</a></strong></td>';//Lien vers profil
                            if ($_SESSION['nomUtilisateur'] == $meilleur_reponse['Identifiant'])
                             {
                             echo'<td id=p_'.$meilleur_reponse['id_reponse'].'>Posté à '.date('H\hi \l\e d M y', strtotime($meilleur_reponse['date_time_reponse'])).'
                             <a href="./poster.php?p='.$meilleur_reponse['id_reponse'].'&amp;action=delete">
                             <img src="./images/supprimer.gif" alt="Supprimer"
                             title="Supprimer ce message" /></a>   
                             <a href="./poster.php?p='.$meilleur_reponse['id_reponse'].'&amp;action=edit">
                             <img src="./images/editer.gif" alt="Editer"
                             title="Editer ce message" /></a></td></tr>';
                             }
                             else
                             {
                             echo'<td>
                             Posté à '.date('H\hi \l\e d M y', strtotime($meilleur_reponse['date_time_reponse'])).'
                             </td></tr>';
                             } 
                              //image relier avec bdd
                                 echo'<tr><td>
                             <img id="profil" src="./images/'.$meilleur_reponse['photo'].'" alt="profil" />';
                            
                                     if($meilleur_reponse['promotion']==1){
                                        echo'Promotion : '.stripslashes(htmlspecialchars($meilleur_reponse['promotion'])).'ere année</td><br>'; 
                                     }else{
                                        echo'Promotion : '.stripslashes(htmlspecialchars($meilleur_reponse['promotion'])).'eme année</td><br>';
                                   }
                             //Message
                             echo'<td>'.nl2br(stripslashes(htmlspecialchars($meilleur_reponse['message']))).'
                             <br /><hr /></td></tr>';
                             
                            while ($data = $query->fetch()){
                                //On commence à afficher le pseudo du créateur du message :
                             //On vérifie les droits du membre
                             //(partie du code commentée plus tard)
                             if(($meilleur_reponse['id_reponse'])!=($data['id_reponse'])){
                             echo'<tr><td><strong>
                             <a href="./voirprofil.php?m='.$data['Identifiant'].'&amp;action=consulter">
                             '.stripslashes(htmlspecialchars($data['Identifiant'])).'</a></strong></td>';//Lien vers profil
                               
                             /* Si on est l'auteur du message, on affiche des liens pour
                             Modérer celui-ci.
                             Les modérateurs pourront aussi le faire, il faudra donc revenir sur
                             ce code un peu plus tard ! */     
                             
                                 if ($_SESSION['nomUtilisateur'] == $data['Identifiant'])
                             {
                             echo'<td id=p_'.$data['id_reponse'].'>Posté à '.date('H\hi \l\e d M y', strtotime($data['date_time_reponse'])).'
                             <a href="./poster.php?p='.$data['id_reponse'].'&amp;action=delete">
                             <img src="./images/supprimer.gif" alt="Supprimer"
                             title="Supprimer ce message" /></a>   
                             <a href="./poster.php?p='.$data['id_reponse'].'&amp;action=edit">
                             <img src="./images/editer.gif" alt="Editer"
                             title="Editer ce message" /></a></td></tr>';
                             }
                             else
                             {
                             echo'<td>
                             Posté à '.date('H\hi \l\e d M y', strtotime($data['date_time_reponse'])).'
                             </td></tr>';
                             }
                             //Détails sur le membre qui a posté -- première ligne relier image profil
                             echo'<tr><td>
                             <img id="profil" src="./images/'.$data['photo'].'" alt="" />';
                            
                                     if($data['promotion']==1){
                                        echo'Promotion : '.stripslashes(htmlspecialchars($data['promotion'])).'ere année</td><br>'; 
                                     }else{
                                        echo'Promotion : '.stripslashes(htmlspecialchars($data['promotion'])).'eme année</td><br>';
                                   }
                             //Message
                             echo'<td>'.nl2br(stripslashes(htmlspecialchars($data['message']))).'
                             <br /><hr /></td></tr>';
                             $i++;
                    }else{}}} //Fin de la boucle ! \o/
                             $query->CloseCursor();
                            


                          ?></table>
                </div>
            </div>
<?php include_once('add_projet.php');?>
</body>
</html>
