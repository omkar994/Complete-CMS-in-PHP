<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php
$_SESSION["trackingURL"]=$_SERVER['PHP_SELF'];
confirmLogin();
?>

<?php
    $author=$_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $currentTime=time();
    $dateTime=strftime("%d-%m-%y",$currentTime);
    if(isset($_POST["submit"])){
        $postTitle  =$_POST["postTitle"];
        $category   =$_POST["category"];
        echo "test";
        $image      =$_FILES["image"]["name"];
        $target     ="uploads/".basename($_FILES["image"]["name"]);
        $postText   =$_POST["postDescription"];

        if(empty($postTitle)){
            $_SESSION["errorMessage"]= "* Post Title is empty";
            redirectTo("addNewPost.php");
        }
        elseif(strlen($postTitle) < 3 || strlen($category) > 100){
            $_SESSION["errorMessage"]="* Post Title should be of min 3 characters max 100";
            redirectTo("addNewPost.php");
        }
        elseif(strlen($postText)> 4999) {
            $_SESSION["errorMessage"]="* Please limit post description to 5000 characters";
            redirectTo("addNewPost.php");

        }

        else{
            global $ConnectingDB;
            $sql= "INSERT INTO cms.posts(datetime,title,category,author,image,post) VALUES(:datetimE,:titlE,:categorY,:authoR,:imagE,:posT)";
            $stmt= $ConnectingDB->prepare($sql);
            $stmt->bindValue(":datetimE", $dateTime);
            $stmt->bindValue(":titlE", $postTitle);
            $stmt->bindValue(":categorY", $category);
            $stmt->bindValue(":authoR", $author);
            $stmt->bindValue(":imagE", $image);
            $stmt->bindValue(":posT", $postText);
            

            $Execute=$stmt-> execute();
            move_uploaded_file($_FILES["image"]["tmp_name"], $target);

            if($Execute){
                $_SESSION["successMessage"]="New Post created";
                redirectTo("addNewPost.php");
            }
            else{
                $_SESSION["errorMessage"]="Something went wrong";
                redirectTo("addNewPost.php");
            }
        }
    }
        
?>

<html>
    <head>
        <title>Posts</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <style>
            .fieldInfo{
                color: rgb(251,174,44);
                font-family:Bitter,Georgia,"Times New Roman, Times,serif";
                font-size:1.2em;
            }

        </style>
    </head>
    <body>
        <div style="height: 6px; background: lightblue;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container" style="background:lavender">
                <a href="#" class="nav-brand">Omkar</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="nav mr-auto">
                    <li class="nav-item"><a href="myProfile.php" class="nav-link"><i class="fas fa-user"></i> My Profile</a></li>            
                    <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="addNewPost.php" class="nav-link">Post</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="admins.php" class="nav-link">Manage Admins</a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link">Comments</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Live Blog</a></li>
                </ul>
                <ul class="nav ml-auto">
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout <i class="fas fa-sign-out-alt"></i></a></li>
                </ul>
            </div>
            </div>
        </nav>
        <div style="height: 7px; background: lightblue;"></div>

        <header class="bg-dark text-white py-3">
            <div class="cointainer">
                <div class="row">
                    <div class="col-md-12">
                      <h1 style="padding-left: 50px;"><i class="fas fa-edit" style="padding-left: 5px;"></i>Add New Post</h1>
                   </div>
                   
                </div>
            </div>
        </header>
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-lg-1 col-lg-10" style="min-height:480px;">
                <?php
                    echo successMessage();
                    echo errorMessage();
                ?>
                <form action="addNewPost.php" method="post" enctype="multipart/form-data">
                    <div class="card  bg-secondary text-light mb-3">
                        
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Post Title: </span></label>
                                <input  class="form-control mb-3" type="text" id="title" name="postTitle">
                            </div>
                            <div class="form-group">
                                <label for="categoryTitle"><span class="fieldInfo">Choose Category: </span></label>
                                <select class="form-control" name="category" id="categoryTitle">
                                <?php
                                global $ConnectingDB;
                                $sql="select id, title from cms.category";
                                $stmt=$ConnectingDB->query($sql);

                                while($DataRows= $stmt-> fetch()){
                                    $Id= $DataRows["id"];
                                    $categoryName=$DataRows["title"];

                                    ?>
                                    <option><?php echo $categoryName; ?></option>

                                <?php } ?>

                                
                                </select>
                            </div>
                            <div class="form-group">
                            
                            <div class="">
                            
                            <input type="File" id="imageSelect" name="image" value="" accept="image/png, image/jpeg">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="post"><span class="fieldInfo">Post:</span></label>
                            <textarea class="form-control" name="postDescription" id="post" cols="30" rows="8"></textarea>
                            </div>
                                
                                <div class="row" style= "min-height:40px; " >
                                <div class="col-lg-6">
                                    <a href="dashboard.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-success btn-block mb-2">Publish
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div> 

        </section>

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