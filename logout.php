<?php

    // Database Connectivity
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="NirmaEats";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

?>


<?php
<<<<<<< HEAD

    include("auth_session_user.php");
    $userid=$_SESSION["userid"];

=======
    session_start();

    // if(isset($_SESSION["userid"]) && $_SESSION["login"]=="OK"){
    //     $userid=$_SESSION["userid"];
    // }
    // else{
    //     header("Location : index.php");
    //     session_destroy();
    // }

    $_SESSION["userid"]=1;

    $userid=1;
>>>>>>> 819cbd203faa54c225290553fe50ae86abcbff27
    // Getting Name of USER
    $sql="";
    $sql.="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;

    $result=mysqli_query($conn,$sql);
    $name="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link href="assets/styles/login_user.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="Logo" style="max-height:60px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                <a class="nav-link" href="#">
                    <?php echo "Hello, $name" ?>
                </a>
                </li>
                <li class="nav-item ">
<<<<<<< HEAD
                <a class="nav-link" href="user_login.php">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="progile.php">My Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="myorder.php">My Orders</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
=======
                <a class="nav-link" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">My Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">My Orders</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Cart</a>
>>>>>>> 819cbd203faa54c225290553fe50ae86abcbff27
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="logout.php">Log Out<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container mb-3 mt-6">
        Thank you so much, Mr. <?php echo $name;?> for paying NirmaEats a visit. It meant a lot to us that you took the time to come by.
        We hope you can visit NirmaEats again soon.
    </div>

    <div class="container mt-0 mb-0 d-flex justify-content-center">
        <form action="confirm_logout.php">
            <button class="btn btn-danger">
                Confirm Logout
            </button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>


</html>