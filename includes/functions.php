<?php
require_once("includes/db.php");
?>

<?php
    function redirectTo($newLocation){
        header("Location:".$newLocation);
        exit;
    }

    function checkUserNameExist($uname){

        global $ConnectingDB;
        $checkUnameSql="select username from cms.admins where username=:uName";
        $stmt= $ConnectingDB->prepare($checkUnameSql);
        $stmt->bindValue(":uName", $uname);
        $stmt->execute();
        $result= $stmt->rowcount();

        if($result==1){
            return true;
        }

        else{
            return false;
        }
    }

    function checkCredentials($userName, $passWord){
        global $ConnectingDB;
        $credFetchSql="select id,username,passwd,admname from cms.admins where username=:UserName and passwd=:PassWord limit 1";
        $stmt= $ConnectingDB->prepare($credFetchSql);
        $stmt->bindValue(":UserName", $userName);
        $stmt->bindValue(":PassWord", $passWord);
        $stmt->execute();
        $result=$stmt->rowcount();

        if($result==1){
            $foundAccount=$stmt->fetch();
            return $foundAccount;
        }
        else{
            return null;
        }


    }

    function confirmLogin(){
        if(isset($_SESSION["UserName"])){
            return true;
        }
        else {
            $_SESSION["errorMessage"]="! NOT AUTHORIZED to Access this page";
            redirectTo("login.php");
        }
    }

    function approveComment(){
        $id=$_GET["approveComment"];  
        //echo $id;
        global $ConnectingDB;
        $apprvBy=$_SESSION["UserName"];
        $approveComntSql="update cms.comments set status='ON',approvedby='$apprvBy' where id='$id'" ;  
        //echo $approveComntSql;
        $Execute=$ConnectingDB->query($approveComntSql);
        if($Execute){ 
            $_SESSION["successMessage"]="Comment approved";
           // redirectTo("comments.php");
                     
        }          
    }
    //deleteComment
    function unapproveComment(){
        $id=$_GET["unapproveComment"];  
        //echo $id;
        global $ConnectingDB;
        $apprvBy=$_SESSION["UserName"];
        $approveComntSql="update cms.comments set status='off',approvedby='$apprvBy' where id='$id'" ;  
        //echo $approveComntSql;
        $Execute=$ConnectingDB->query($approveComntSql);
        if($Execute){ 
            $_SESSION["successMessage"]="Comment Unapproved";
           // redirectTo("comments.php");
                     
        }          
    }
?>








