<?php 
	include_once('verif.php');
	$page = basename(__FILE__);
	$idsalon = $_GET['id'];
	$_SESSION['idsalon']=$idsalon;
	include_once('config.php');
	$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
	if(isset($_POST['input_msg'])){
		$today = getdate();
	    $days=$today["year"]."-".$today["mon"]."-".$today["mday"]." ".$today["hours"].":".$today["minutes"].":".$today["seconds"].".0000";
	    $importMessage=$bdd->prepare("INSERT INTO msg_tchat (id_utilisateur,contenu,datemsg,id_salon) VALUES (:id,:messageInput,:days,:id_salon)");
	    $importMessage->bindparam(":messageInput",$_POST['input_msg']);
	    $importMessage->bindparam(":id",$_SESSION['nomUtilisateur']);
	    $importMessage->bindparam(":days",$days);
	    $importMessage->bindparam(":id_salon",$idsalon);
	    $importMessage->execute();
	}
?>
<html>
<head>
  <title>Antre Aide Tudiant</title>
    <?php include_once('header.php');?>
    <link rel="stylesheet" type="text/css" href="tchat.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script>
            //je fais une fonction qui va chercher l'heure en ajax
            function getMsg() {
                //appel en GET de la page php qui renvoie l'heure
                $.get("inc_tchat.php", function (data) {
                    //dans data, il y a ce que le php a renvoyé (ici de l'html)
                    //je mets cet html dans le div
                    $("#tchat").html(data);
                });
            }

            //quand la page est prête
            $(document).ready(function () {
                //j'appelle cette fonction une première fois
                getMsg();

                //je programme un timer pour l'appeler toutes les 10 secondes (10000 millisecondes)
                window.setInterval("getMsg()", 5000);
            });
        </script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php include_once('menu.php');?>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <?php include_once('navbar_profil.php');?>
			<div class="user-dashboard">
        		<div class="container">
					<div class="row">
					  <div id="tchat">
				        <div class="col-sm-4">
				        	
				        	<?php
							$req = $bdd->prepare("SELECT DISTINCT id_utilisateur FROM autorisation_salon WHERE  id_salon = :id");
		                    $req->bindParam(":id",$idsalon);
		                    $req->execute();
		                    $membreSalon = $req->fetchall();
		                    $i = 0;
		                    while (isset($membreSalon[$i])) {
		                        echo '<a href="profil.php?utilisateurs='.$membreSalon[$i][0].'" class="chatperson">
				                    	<span class="chatimg">
				                        	<img src="http://via.placeholder.com/50x50?text=A" alt="" />
				                    	</span>
				                    	<div class="namechat">
				                        	<div class="pname">'.$membreSalon[$i][0].'</div>
				                    	</div>
				                	</a>';
								$i++;
		                    }?>
				        </div>
				        <div class="col-sm-8">
				            <div class="chatbody">
								<table class="table">
									<?php 
										$req = $bdd->prepare("SELECT id_utilisateur, datemsg, contenu FROM msg_tchat WHERE  id_salon = :id");
			                            $req->bindParam(":id",$idsalon);
			                            $req->execute();
			                            $msg = $req->fetchall();
			                            $i = 0;
			                            while (isset($msg[$i])) {
			                            	echo '<tr>
				                      				<td>'.$msg[$i][0].'</td>
				                      				<td>'.$msg[$i][2].'</td>
				                      				<td>'.$msg[$i][1].'</td>
				                   				</tr>';
								            $i++;
			                            }
									?>
								</table>
							</div>
						</div>
					</div>

				                  <div class="row">
				                  	<form action="accestchat.php?id=<?php echo $idsalon ?>" method="POST" id="msg">
					                    <div class="col-xs-9">
					                    	  <input type="text" name="input_msg" placeholder="Ecrire ici..." class="form-control" />
					                    </div>
					                    <div class="col-xs-3">
					                      <button type="submit" form="msg" value="submit" class="btn btn-info btn-block">Envoyer</button>
					                    </div>
				                	</form>
				                  </div>

				                 </div>
				             </div>
						</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('add_projet.php');?>
</body>
</html>