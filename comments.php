<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php
$_SESSION["trackingURL"]=$_SERVER['PHP_SELF'];
confirmLogin();
?>
<html>
    <head>
        <title>Comments</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="C:\xampp\htdocs\CMS\css\style.css">
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
                    <li class="nav-item"><a href="post.php" class="nav-link">Post</a></li>
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
                      <h1 style="padding-left: 50px;"><i class="fas fa-comments  mr-4 ml-3"></i>Manage Comments</h1>
                   </div>
                </div>
            </div>
        </header>
        <section class="container py-2 mb-4">
           <!-- <div class="row" style="min-height:50px; background:red">
                <div class="col-lg-10" style="min-height:50px; background:yellow"></div>
            </div> -->
            <div class="row">
                <div class="col-lg-12" >
                <?php
                echo successMessage();
                echo errorMessage();
                ?>
                <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">No.</th>
      <th scope="col">Name</th>
      <th scope="col">Date</th>
      <th scope="col">Comment</th>
      <th scope="col">Action</th>
      <th scope="col">Status</th>
      <th scope="col">Detail</th>
    </tr>
  </thead>
  <?php
    global $ConnectingDB;
    $fetchAllCommentSql="select * from cms.comments";
    $Execute=$ConnectingDB->query($fetchAllCommentSql);
    $srNo=0;

    while($DataRows=$Execute->fetch()){
        $commentId=$DataRows["id"];
        $commentDate=$DataRows["datetime"];
        $commenterName=$DataRows["name"];
        $commentContent=$DataRows["comment"];        
        $commentPostId=$DataRows["post_id"];
        $commentStatus=$DataRows["status"];
        if(strlen($commentContent)>50){
            $commentContent=substr($commentContent,0,50)."...";
        }
        
        if(strlen($commentDate)>8){
            $commentDate=substr($commentDate,0,8)."...";
        }
        $srNo++;    
    ?>
    <tbody>
        <tr>
            <td><?php echo $srNo; ?></td>
            <td><?php echo $commenterName; ?></td>
            <td><?php echo $commentDate; ?></td>
            <td><?php echo $commentContent; ?></td>
            <td><a href="?approveComment=<?php echo $commentId;?>">Approve </a> <a href="?unapproveComment=<?php echo $commentId; ?>">Delete</a></td>
            <td><?php echo $commentStatus; ?></td>
            <td><a href="fullPost.php?id=<?php echo $commentPostId;?>" style="" ><span class="btn btn-info btn-block">Post ></span> </a></td>
        </tr>
    </tbody>

  <?php } //ending of while loop ?>
  <?php
            if (isset($_GET['approveComment']))
            {
                approveComment();
            }
            if (isset($_GET['unapproveComment']))
            {
                unapproveComment();
            }
            
            ?>
</table>

                </div>
            </div>

        </section>
        <?php
           /* if (isset($_GET['approveComment']))
            {
                
               // echo $commentId;
                approveComment();
            }*/
            
            ?>
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