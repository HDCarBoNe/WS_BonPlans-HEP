<?php
session_start();
session_destroy();
echo '<script language="JavaScript" type="text/javascript">window.location.replace("index.php");</script>';

?>
