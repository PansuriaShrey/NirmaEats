<?php

    include('db.php');   

?>


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
    // Getting Name of USER
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

?>

<?php
    
    // Getting all the restaurants
    $sql="";
    $sql.="SELECT * FROM `restaurant` ";

    $result=mysqli_query($conn,$sql);
    $val="Not Searched";

    if(isset($_GET["getdish"])){
        $search=$_GET["getdish"];

        // Checking with dish names
        $sql="SELECT * FROM `dish` WHERE `dishName` LIKE '%$search%'";
        $dishes=mysqli_query($conn,$sql);
        $restaurant_serving_dishes=array();
        $str="resId = 0 ";
        while($row = mysqli_fetch_assoc($dishes)){
            $resid=$row["resId"];
            array_push($restaurant_serving_dishes,$resid);
            $str.="OR resId = $resid ";
        }

        // checking with restaurant names
        $sql="SELECT * FROM `restaurant` WHERE `resName` LIKE '%$search%'";
        $dishes=mysqli_query($conn,$sql);
        $restaurant_serving_dishes=array();
        while($row = mysqli_fetch_assoc($dishes)){
            $resid=$row["resId"];
            array_push($restaurant_serving_dishes,$resid);
            $str.="OR resId = $resid ";
        }

        $sql="SELECT * FROM `restaurant` WHERE ".$str;
        $result=mysqli_query($conn,$sql);
        $val="Searched";
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
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/assets2/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
    <style>
    .not-active {
        color: rgba(255, 255, 255, 0.55)!important;
    }
    .not-active:hover {
        color: rgba(255, 255, 255, 0.75)!important;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="user_login.php">
            <img src="assets/images/logo.png" alt="Logo" style="max-height:60px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link not-active" href="user_login.php">
                    <?php echo "Hello, $name" ?>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="user_login.php">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link not-active" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link not-active" href="myorder.php">My Orders</a>
                </li>
                <li class="nav-item">
                <a class="nav-link not-active" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                <a class="nav-link not-active" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

        <!-- Search Bar -->
        <center>
            <!-- <div class="input-group w-25 col-sm-12 align-items-center" style="margin: 20%; margin-top:20px; margin-bottom:auto"> -->
            <form action="user_login.php" method="GET">
                <!-- <div class="col-md-4 offset-md-4 mt-5 border border-success pt-3"> -->
                    <div class="input-group w-25 mt-3">
                        <input type="text" class="form-control" placeholder="Enter Dish Name" aria-label="Recipient's username" name="getdish">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                <!-- </div> -->
            </form>
            <!-- </div>  -->
        </center>

        <!-- <div class='container w-75'>
            <div class='row bg-light my-auto'>
                <div class='col' >
                    <img src='assets/images/res1.jpeg' alt='' class='img-thumbnail' style='width: 40%; margin: 2%;'>
                </div>
                <div class='col text-dark'>
                    <h3>$rname</h3>
                    <h4>Restaurant Email-ID</h4>
                    <h4>Restaurant Address</h4>
                    <p>
                        Restaurant type<br>
                        Opening Time and Closing Time
                    </p>
                </div>
                
                <div class='w-100'></div>
            </div>
        </div>

        <center>
        <div class='container' style='width: 40%; margin: 2%;'>
            <div class='row bg-light my-auto'>
                <div class='col' >
                    <img src='assets/images/res1.jpeg' alt='' class='img-thumbnail' style='width: 25%; margin: 2%;'>
                </div>
                <div class='w-100'></div>
                <div class='col text-dark'>
                <h3>$rname</h3>
                    <h4>Restaurant Email-ID</h4>
                    <h4>Restaurant Address</h4>
                    <p>
                        Restaurant type<br>
                        Opening Time and Closing Time
                    </p>
                </div>
                </div>
            </div>
        </div>
        </center> -->


    <?php
        include("printRestaurant.php");

        if($val=="Searched"){
            printRestaurantSecond($result);
        }
        else{
            include("recommendation_system.php");
            printRestaurantThird($recommended_restaurants,$conn);
        }
    ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.1.0/js/fontawesome-iconpicker.min.js'></script>
</body>


</html>