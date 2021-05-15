<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");
?>
<?php
confirmLogin();
?>

<?php

$searchDeleteId=$_GET["id"];
global $ConnectingDB;
$fetchImgNameSql="select image from cms.posts where id=$searchDeleteId";
$stmt= $ConnectingDB->query($fetchImgNameSql);
while($dataRow=$stmt->fetch()){
    $imageNameToBeDeleted=$dataRow["image"];
}
$deletePostSql="delete from cms.posts where id=$searchDeleteId";
$deleteRecord= $ConnectingDB->query($deletePostSql);
$targetPathToDeleteImg="uploads/$imageNameToBeDeleted";

if($deleteRecord){
    $_SESSION["successMessage"]="Post deleted successfully";
    unlink($targetPathToDeleteImg);
    redirectTo("posts.php");
}


?>