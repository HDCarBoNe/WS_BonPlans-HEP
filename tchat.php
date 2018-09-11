<?php include_once('verif.php');
$page = basename(__FILE__); ?>
<html>
<head>
  <title>Antre Aide Tudiant</title>
    <?php include_once('header.php');?>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php include_once('menu.php');?>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                   <?php include_once('navbar_profil.php');?>
                <div class="user-dashboard">
                    <h1>Liste des tchats disponibles <g:hangout render="createhangout"></g:hangout></h1>

                    <div class="row">
                        <div class="col-md-10 col-sm-5 col-xs-12 gutter">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td><strong>Nom du salon</strong></td>
                                        <td><strong>Propriétaire du salon</strong></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        include_once ('config.php');
                                        $bdd = new PDO("mysql:host=".Config::SERVERNAME.";dbname=".Config::DBNAME, Config::USER, Config::PASSWORD);
                                        $req = $bdd->prepare("SELECT libelle_salon, createur, Id_salon FROM salons ORDER BY Id_salon ");
                                        $req->execute();
                                        $resultat = $req->fetchall();
                                        $i = 0;
                                        //var_dump($resultat);
                                        while (isset($resultat[$i])) {
                                            echo"<tr><td><a href='accestchat.php?id=".$resultat[$i][2]."' class='btn btn-default'>".$resultat[$i][0]."</a></td>
                                                <td>".$resultat[$i][1]."</td></tr>";
                                            $i++;
                                        }
                                        $bdd= null;
                                        $i = null;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include_once('add_projet.php');?>
</body>
</html>