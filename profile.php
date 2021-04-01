<?php
    include("auth_session_user.php");

    // if(isset($_SESSION["userid"]) && $_SESSION["login"]=="OK"){
    //     $userid=$_SESSION["userid"];
    // }
    // else{
    //     header("Location : index.php");
    //     session_destroy();
    // }

    // $_SESSION["userid"]=1;
    $userid=$_SESSION["userid"];

    // SELECT * FROM `user` WHERE `userId` = $userid

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="NirmaEats";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "<center class='text-light'>Connected successfully with Database</center><br>";

    $sql="";
    $sql.="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;

    $result=mysqli_query($conn,$sql);
    $name="";
    $email="";
    $phoneno="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
        $email=$row["emailId"];
        $phoneno=$row["mobileNumber"];
    }
    
    // echo "<center class='text-light'>$name and $email</center><br>";

    // SELECT * FROM `bill` WHERE userId = 
    $sql="";
    $sql.="SELECT * FROM `bill` WHERE `userId` = ";
    $sql.=$userid;
    $result=mysqli_query($conn,$sql);

    $total_orders=mysqli_num_rows($result);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=RocknRoll+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- <link href="assets/styles/login_user.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>My Profile</title>
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
                <a class="nav-link" href="user_login.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="profile.php">My Profile<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="myorder.php">My Orders</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container card shadow py-3 px-3 mb-3 my-4" style="width: 75%;">
        <div class="form-row my-2">
            <div class="col-md-6 mt-2 text-dark">
                <label> Name : </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> <?php if(isset($name)) echo $name; ?> </label>
            </div>
            <!-- <div class="col-md-6 mt-2 text-dark">
                <label> Last Name : </label>
            </div>
            <div class="col-md-6 mt-2">
                <label> </label>
            </div> -->
            <div class="col-md-6 mt-2 text-dark">
                <label> Email : </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> <?php if(isset($email)) echo $email; ?> </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> Phone Number : </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> <?php if(isset($phoneno)) echo $phoneno; ?> </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> Total number of orders : </label>
            </div>
            <div class="col-md-6 mt-2 text-dark">
                <label> <?php if(isset($total_orders)) echo $total_orders; ?> </label>
            </div>
        </div>  
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>


</html>