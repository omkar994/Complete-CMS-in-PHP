<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php
if(isset($_SESSION["UserName"])){
    redirectTo("dashboard.php");
}
?>
<?php
    if(isset($_POST["login"])){
        $uname=$_POST["Username"];
        $passwd=$_POST["Password"];
        if(empty($uname) || empty($passwd)){
            $_SESSION["errorMessage"]= "* All fields must be filled";
            redirectTo("login.php");
        }
        else{
        //checking credentials start
        $foundAccount=checkCredentials($uname,$passwd);

        if($foundAccount){
            $_SESSION["id"]=$foundAccount["id"];
            $_SESSION["UserName"]=$foundAccount["username"];
            $_SESSION["PassWord"]=$foundAccount["passwd"];
            $_SESSION["AdmName"]=$foundAccount["admname"];
            
            $_SESSION["successMessage"]="Welcome ".$_SESSION["AdmName"];
             if(isset($_SESSION["trackingURL"])){
                echo $_SESSION["trackingURL"];
                redirectTo($_SESSION["trackingURL"]);
             }
             else{
                redirectTo("posts.php");
             }
        }

        else{
            $_SESSION["errorMessage"]= "Invalid Username or Password";
            redirectTo("login.php");
        }
        //checking credentials end

    }
    }
?>

<html>
    <head>
        <title>Login || CMS </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="C:\xampp\htdocs\CMS\css\style.css">
    </head>
    <body>
        <div style="height: 10px; background: lightblue;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container" >
                <a href="#" class="nav-brand"><h3>OMKARRAUT.COM</h3></a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                
                
            </div>
            </div>
        </nav>
        <div style="height: 10px; background: lightblue; "></div>
        <br><br><br><br>
        <section class="container py-2 mb-4">
            <div class="row" style="min-height:400px;">
                <div class="offset-sm-3 col-sm-6" style="min-height:400px;">
                <?php
                 echo successMessage();
                 echo errorMessage();
                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h1 style="padding-left:100px">Complete CMS</h1>
                    <div class="card-body bg-dark">
                    </div>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username"><span style="margin-left:20px">Username</span></label>
                            <div class="input-group mb-3 px-3" >
                                <div class="input-group-prepend" >
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"><span style="margin-left:20px">Password</span></label>
                            <div class="input-group mb-3 px-3" >
                                <div class="input-group-prepend" >
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" name="Password">
                            </div>
                        </div>
                        <input type="submit" name="login" class="btn btn-info" style="float:right; margin-right:20px" value="Login" >
                        </div>
                    </form>
                </div>
                </div>
            </div> 

        </section>
        <br><br><br>
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