<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");
?>
<html>
<?php
$_SESSION["trackingURL"]=$_SERVER['PHP_SELF'];
confirmLogin();
?>

<head>
    <title>Posts</title>
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
                    <h1 style="padding-left: 50px;"><i class="fas fa-blog" style="color:#27aae1; padding-right:3px"></i>Blog Posts</h1>
                </div>
                <div class="col-lg-3" style="padding-left: 50px;">
                    <a class="btn btn-primary btn-block mb-2" href="addNewPost.php"><i class="fas fa-edit" style="padding-right: 5px;"></i>Add New Post</a>
                </div>

                <div class="col-lg-3" style="padding-left: 30px;">
                    <a class="btn btn-info btn-block mb-2" href="categories.php"><i class="fas fa-folder-plus" style="padding-right: 5px;"></i>Categories</a>
                </div>

                <div class="col-lg-3" style="padding-left: 30px;">
                    <a class="btn btn-warning btn-block mb-2" href="admins.php"><i class="fas fa-user-plus" style="padding-right: 5px;"></i>Add New Admin</a>
                </div>

                <div class="col-lg-3" style="padding-left: 30px; ">
                    <a class="btn btn-success btn-block mb-2" href="comments.php"><i class="fas fa-check" style="padding-right: 5px;"></i>Approve Comments</a>
                </div>
            </div>
        </div>
    </header>
    <?php
    echo successMessage();
    echo errorMessage();
    ?>
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Actions</th>
                            <th>Live Preview</th>

                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "select * from cms.posts";
                    $stmt = $ConnectingDB->query($sql);
                    $sr = 0;

                    while ($DataRows = $stmt->fetch()) {
                        $id = $DataRows["id"];
                        $dateTime = $DataRows["datetime"];
                        $postTitle = $DataRows["title"];
                        $category = $DataRows["category"];
                        $author = $DataRows["author"];
                        $imgName = $DataRows["image"];
                        $sr++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sr; ?></td>
                                <td>
                                    <?php if (strlen($postTitle) > 20) {
                                        $postTitle = substr($postTitle, 0, 17) . "...";
                                    } ?>
                                    <?php echo $postTitle; ?></td>
                                <td>
                                    <?php if (strlen($category) > 10) {
                                        $postTitle = substr($postTitle, 0, 10) . "...";
                                    } ?>
                                    <?php echo $category; ?></td>
                                <td><?php echo $dateTime; ?></td>
                                <td>
                                    <?php if (strlen($author) > 6) {
                                        $postTitle = substr($postTitle, 0, 5) . "...";
                                    } ?>
                                    <?php echo $author; ?></td>
                                <td> <img src="uploads/<?php echo $imgName; ?>" width="100px" height="70px"></td>
                                <td>Comments</td>
                                <td><span><a href="editPost.php?id=<?php echo $id;?>" class="btn btn-warning">Edit</a></span> <span><a href="deletePost.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></span></td>
                                <td><a href="fullPost.php?id=<?php echo $id; ?>" target="_blank" class="btn btn-primary">Live Preview</a></td>

                            </tr>
                        </tbody>

                    <?php } ?>
                </table>

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