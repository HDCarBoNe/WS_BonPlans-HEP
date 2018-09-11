<!DOCTYPE html>

<html>
    <head>
        <title>Interface Menu Chatroom</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="style.css"  type="text/css" rel="stylesheet">
        <link href="login.css"  type="text/css" rel="stylesheet">
        <link href="testbottstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="text-center" >
            <div class="card-img-overlay d-flex">
                <div class="my-auto mx-auto item-center" style="width: 300px;" >
                    <img src="logo_login.png">
                    <form class="form-group" action="cibleformulaireinscription.php" method="POST">
                        <h2>Inscrivez-vous !</h2>
                        <br>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="id" placeholder="Identifiant">
                        <input type="email" class="form-control" id="formGroupExampleInput" name="mail" placeholder="Adresse Mail">
                        <input type="password" class="form-control" id="formGroupExampleInput" name="mdp" placeholder="Mot de Passe">
                        <input type="text" class="form-control" id="formGroupExampleInput" name="nom" placeholder="Nom">
                        <input type="text" class="form-control" id="formGroupExampleInput" name="prenom" placeholder="Prénom">
                        <input type="number" class="form-control" id="formGroupExampleInput" name="promotions" placeholder="Promotions">
                        <br><button type="submit" class="btn btn-outline-dark" style="background-color: #C0C2C2;">Inscription</button>
                    </form>
                </div>
            </div>
    </body>
</html>