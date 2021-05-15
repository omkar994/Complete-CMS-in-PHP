<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");
?>
<?php
$_SESSION["trackingURL"]=$_SERVER['PHP_SELF'];
confirmLogin();
?>
<?php $searchQueryParameter=$_GET["id"]; ?>
<?php 
global $ConnectingDB;
$author="Omkar";
date_default_timezone_set("Asia/Kolkata");
$currentTime=time();
$dateTime=strftime("%d-%m-%y",$currentTime);

if(isset($_POST["submit"])){
    $commenterName=$_POST["commenterName"];
    $commenterEmail=$_POST["commenterEmail"];
    $comment=$_POST["commenterThoughts"];

    if(empty($commenterName) || empty($commenterEmail) || empty($comment)){
        $_SESSION["errorMessage"]= "* All fields must be field";
        redirectTo("fullPost.php?id=$searchQueryParameter");
    }
    elseif(strlen($comment)>499){
        $_SESSION["errorMessage"]="* Please limit comment to 500 characters";
        redirectTo("fullPost.php?id=$searchQueryParameter");
    }

    else{
        $commentInsertSql="INSERT INTO cms.comments(datetime, name, email, comment, approvedby, status, post_id) VALUES (:datetimE, :namE, :emaiL, :commenT, 'pending', 'off', :postIdFromUrl)";
        $stmt=$ConnectingDB->prepare($commentInsertSql);
        $stmt->bindValue(":datetimE",$dateTime);
        $stmt->bindValue(":namE",$commenterName);
        $stmt->bindValue(":emaiL",$commenterEmail);
        $stmt->bindValue(":commenT",$comment);
        $stmt->bindValue(":postIdFromUrl",$searchQueryParameter);
        $Execute=$stmt->execute();

        if($Execute){
            $_SESSION["successMessage"]="Comment added Successfully";
            redirectTo("fullPost.php?id=$searchQueryParameter");
        }
        else{
            $_SESSION["errorMessage"]="Something went WRONG!";
            redirectTo("fullPost.php?id=$searchQueryParameter");
        }

    }

}
?>

<html>
    <head>
        <title>Blogs</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        
    </head>
    <body>
        <div style="height: 6px; background: lightblue;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container" >
                <a href="#" class="nav-brand">Omkar</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="nav mr-auto">
                            
                    <li class="nav-item"><a href="blog.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Feature</a></li>
          
                </ul>
                <ul class="nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="blog.php" method="get">
                        <div class="form-group">
                            <input class="form-control mr-2 mt-1" type="text" name="search" placeholder="search">
                            <button type="submit" class="btn btn-primary mt-1" name="searchButton">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
            </div>
        </nav>
        <div style="height: 7px; background: lightblue;"></div>

        <div class="container">
            <div class="row mt-3">
                <div class="col-sm-8" >
                    <h1 >The Complete Responsive CMS Blog</h1>
                    <h1 class="lead">CMS Project by Omkar</h1>
                    <?php
                    global $ConnectingDB;
                    $readPostId=$_GET["id"];

                    if(isset($_GET["searchButton"])){
                        $searchKey=$_GET["search"];
                        $sql="select * from cms.posts where title like :search or post like :search or category like :search or author like :search";
                        $stmt=$ConnectingDB->prepare($sql);
                        $stmt->bindValue(':search','%'.$searchKey.'%');
                        $stmt->execute();
                    }

                    else{

                        if(!isset($readPostId)){
                            $_SESSION["errorMessage"]="BAD Request !";
                            redirectTo("blog.php");
                        }

                        $sql= "select * from cms.posts where id='$readPostId'";
                        $stmt=$ConnectingDB->query($sql);
                    }
                    
                    while($DataRows=$stmt-> fetch()){
                        $id=$DataRows["id"];
                        $dateTime=$DataRows["datetime"];
                        $postTitle=$DataRows["title"];
                        $category=$DataRows["category"];
                        $author=$DataRows["author"];
                        $post=$DataRows["post"];
                        $imgName=$DataRows["image"];

                    ?>
                  
                       <img src="uploads/<?php echo$imgName;?>" class="img-fluid card-img-top" style="max-height:450px">
                       <div class=card-body>
                           <h4 class="card-title"><?php echo $postTitle;?></h4>
                           <small class="text-muted">Written by <?PHP echo $author;?> On <?php echo $dateTime;?></small>
                           <span style="float:right;" class="badge badge-dark text-light">Comments 20</span>
                           <hr>
                           <div class="card">
                           
                           <p class="card-text"><?php echo htmlentities($post);?></p>
                       </div>
                   </div>
                   <?php }?>
                   <!--comments section-->
                   <?php
                   echo successMessage();
                   echo errorMessage();
                   ?>
                    <!--fetching comments-->
                    <span style="font:caption; color: tan;">comments</span>
                    <?php
                    global $ConnectingDB;
                    $fetchCommentSql="select datetime,name,comment from cms.comments where post_id=$searchQueryParameter and status='ON'";
                    $stmt=$ConnectingDB->query($fetchCommentSql);
                    while($DataRows=$stmt->fetch()){
                        $commentDate=$DataRows['datetime'];
                        $commenterName=$DataRows['name'];
                        $commentContent=$DataRows['comment'];
        
                    ?>
                    
                    <div class="media">
                        <div class="media-body">
                        <h6 class="lead"><?php echo $commenterName;?></h6>
                        <p class="small"><?php echo $commentDate;?></p>
                        <p><?php echo $commentContent;?></p>
                        </div>
                    </div>
                    <hr>

                    <?php } ?>    

                   <div class="">
                   <form action="fullPost.php?id=<?php echo $searchQueryParameter; ?>" method="post">
                        <div class="card mb-3">
                            <div class="card-header">
                            <h5 style="font:caption; color: tan;">share your thoughts</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="commenterName" placeholder="name">
                                </div>
                                </div>

                                <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="text" name="commenterEmail" placeholder="email">
                                </div>
                                </div>

                                <div class="form-group">
                                <textarea class="form-control" name="commenterThoughts" id="" cols="92" rows="6" placeholder="your thoughts"></textarea>
                                </div>

                                <div class="">
                                <button type="submit" name="submit" class="btn btn-primary" style="float:right;">Submit</button>
                                </div>
                            </div>
                        </div>
                   </form>
                   </div>

                </div>
                <div class="col-sm-4" style="background:yellow; min-height:40px;"></div>
            </div>
        </div>
         
            
        
        <br>
        <footer class="bg-dark text-white">
            <div class="cointainer">
                    <p class="lead text-center">Design by Omkar Raut <span id="year"></span></p>
            </div>
            <div style="height: 7px; background: lightblue;"></div>
        </footer>
        

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>    
</body>
</html>