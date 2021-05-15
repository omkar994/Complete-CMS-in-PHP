<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>

<?php
  $_SESSION["id"]=null;
  $_SESSION["UserName"]=null;
  $_SESSION["PassWord"]=null;
  $_SESSION["AdmName"]=null;

  session_destroy();
  redirectTo("login.php")

?>