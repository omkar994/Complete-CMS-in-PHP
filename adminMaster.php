<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php
$_SESSION["trackingURL"]=$_SERVER['PHP_SELF'];
//echo $_SESSION["trackingURL"];
confirmLogin();
?>

<?php
    $author=$_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $currentTime=time();
    $dateTime=strftime("%d-%m-%y",$currentTime);
    if(isset($_POST["submit"])){
        $userName=$_POST["username"];
        $passWord=$_POST["password"];
        $confirmPassword=$_POST["confirmPassword"];
        $adminName=$_POST["Name"];

        if(empty($userName) || empty($passWord) || empty($confirmPassword)){
            $_SESSION["errorMessage"]= "* USERNAME, PASSWORD, CONFIRM PASSWORD all are MANDATORY";
            redirectTo("adminMaster.php");
        }
        elseif(strlen($userName) < 3 || strlen($userName) > 50){
            $_SESSION["errorMessage"]="* USERNAME should be min 3 and max 50 characters";
            redirectTo("adminMaster.php");
        }

        elseif(strlen($passWord)<5 || strlen($passWord) > 50){
            $_SESSION["errorMessage"]="* PASSWORD should be min 5 and max 50 characters";
            redirectTo("adminMaster.php"); 
        }

        elseif($passWord != $confirmPassword){
            $_SESSION["errorMessage"]="* PASSWORD and CONFIRM PASSWORD did not match";
            redirectTo("adminMaster.php"); 
        }

        elseif(checkUserNameExist($userName)){
            $_SESSION["errorMessage"]=" Username alerady exist! ";
            redirectTo("adminMaster.php");
        }

        else{
            global $ConnectingDB;
            $sql= "INSERT INTO cms.admins(datetime,username,passwd,admname,addedby) VALUES(:datetimE,:unamE,:passwD,:admnamE,:addedbY)";
            $stmt= $ConnectingDB->prepare($sql);
            $stmt->bindValue(":unamE", $userName);
            $stmt->bindValue(":passwD", $passWord);
            $stmt->bindValue(":datetimE", $dateTime);
            $stmt->bindValue(":admnamE", $adminName);
            $stmt->bindValue(":addedbY", $author);

            $Execute=$stmt-> execute();
            if($Execute){
                $_SESSION["successMessage"]="New Admin created successfully";
                redirectTo("adminMaster.php");
            }
            else{
                $_SESSION["errorMessage"]="Something went wrong";
                redirectTo("adminMaster.php");
            }



        }
    }
        
?>

<html>
    <head>
        <title>Admins</title>
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
                      <h1 style="padding-left: 50px;"><i class="fas fa-user mr-4 ml-3" ></i>Admin Master</h1>
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
                <form action="adminMaster.php" method="post">
                    <div class="card  bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="uname"><span class="fieldInfo">Username: </span></label>
                                <input  class="form-control mb-3" type="text" id="uname" name="username">
                                
                                <label for="name"><span class="fieldInfo">Name: </span></label>
                                <small class="text-muted mb-4">*optional</small>
                                <input  class="form-control mb-3" type="text" id="name" name="Name">
                                

                                <label for="pass"><span class="fieldInfo">Password: </span></label>
                                <input  class="form-control mb-3" type="password" id="pass" name="password">
                                
                                
                                <label for="confirmPass"><span class="fieldInfo mt-2">Confirm Password: </span></label>
                                <input  class="form-control mb-3" type="password" id="confirmPass" name="confirmPassword">
                                

                                <div class="row" style= "min-height:40px; " >
                                <div class="col-lg-6">
                                    <a href="dashboard.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-success btn-block mb-2">Add
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