<?php
session_start();
$verif= $_SESSION['nomUtilisateur'];
if (!isset($verif)){
	header('Location: index.php');
}
?>