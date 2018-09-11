<?php include_once('verif.php');
$idsalon=$_SESSION['idsalon'];
include_once ('config.php');
$bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD); ?>
<div class="row">
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