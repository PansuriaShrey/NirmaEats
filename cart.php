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


    include("auth_session_user.php");
    $userid=$_SESSION["userid"];

    // Getting Name of USER
    $sql="";
    $sql.="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;

    $result=mysqli_query($conn,$sql);
    $name="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
    }

    $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
    $tempsql.=$userid;
    $cartid=mysqli_query($conn,$tempsql);

    if(mysqli_num_rows($cartid)==0){
        //creating new
        $tempsql="INSERT INTO `cart` (`userId`) VALUES (";
        $tempsql.=$userid;
        $tempsql.=");";
        mysqli_query($conn,$tempsql);
        $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
        $tempsql.=$userid;
        $cartid=mysqli_query($conn,$tempsql);
        $cartid=mysqli_fetch_assoc($cartid)["cartId"];
    }
    else{
        // Using it
        $cartid=mysqli_fetch_assoc($cartid)["cartId"];
    }
    // echo "<center class='text-light'>".$cartid."</center><br>";

    $tempsql="SELECT * FROM `cartDetail` WHERE cartId=$cartid";
    $entirecart=mysqli_query($conn,$tempsql);

?>

<?php
    $dishidgot=$_GET["dishid"];
    // echo "<cente r class='text-light'>".$dishid."</center><br>";
    if(isset($_POST["remove"])){
        $tempsql="DELETE FROM `cartDetail` WHERE dishID=$dishidgot";
        mysqli_query($conn,$tempsql);
        echo "<script>alert('Dish is removed from Cart')</script>";
        echo "<script>window.location = './cart.php'</script>";
        exit;
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
    <link href="assets/styles/cart.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>Cart</title>
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
                <li class="nav-item">
                <a class="nav-link" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="myorder.php">My Orders</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="cart.php">Cart <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

                <!-- <center>
                <section id='testimonials' class='testimonials' style='width: 65%; margin: 2%;'>
                <div class='container'>

                <div class='testimonials-slider swiper-container'>
                <div class='swiper-wrapper'>

                    <div class='swiper-slide'>
                    <div class='testimonial-wrap'>
                        <div class='testimonial-item bg-light'>
                        <img src='assets/images/$rpic' width='200' height='200' class='testimonial-img' alt=''>
                        <h3>$rname</h3>
                        <h4 class='text-danger'>Email : $remail</h4>
                        <h4>Address : $raddress</h4>
                        <p>
                            Restaurant Type : $rtype<br>
                            Restaurant Opening Time : $rot <br>
                            Restaurant Closing Time :  $rct
                        </p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                </div>
                </section>
                </center> -->

<div class="container-fluid bg-light">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>
                <?php
                    $total=0;
                    $count=0;
                    while($row = mysqli_fetch_assoc($entirecart)){
                        $dishid=$row["dishId"];
                        $quantity=$row["Quantity"];
                        global $conn;
                        $tempsql="SELECT * FROM dish WHERE dishid=$dishid";
                        $dish=mysqli_query($conn,$tempsql);
                        $dish=mysqli_fetch_assoc($dish);
                        $dishpic=$dish["dishPicture"];
                        $dishname=$dish["dishName"];
                        $dishprice=$dish["dishPrice"];
                        $total+=$quantity*$dishprice;
                        $count+=$quantity;
                        $resid=$row["resId"];
                        $dishtype=$dish["dishType"];
                        echo "
                            <div class=\"border rounded\">
                            <div class=\"row bg-white\">
                                <div class=\"col-md-3 pl-0 d-flex justify-content-center\">
                                    <img src=\"assets/images/$dishpic\" alt=\"Image1\" class=\"img-fluid img3\">
                                </div>
                                <div class=\"col-md-8\">
                                    <table class='table text-center mb-0'>
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope='col' colspan='2' class='text-center font-weight-bold'>$dishname</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <th scope='row' class='text-center w-50'>Dish Type</th>
                                            <td>$dishtype </td>
                                            </tr>
                                            <tr>
                                            <th scope='row' class='text-center'>Quantity</th>
                                            <td>$quantity</td>
                                            </tr>
                                            <tr>
                                            <th scope='row' class='text-center'>Price</th>
                                            <td>$dishprice</td>
                                            </tr>
                                            <tr>
                                            <th scope='row' class='text-center' colspan=2>
                                                <form action='./cart.php?dishid=$dishid' method='POST'>
                                                    <input type='submit' value='Remove' class='text-danger' name='remove'>
                                                </form>
                                            </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25 mb-2">
            <div class="pt-4 ">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                            echo "<h6>Price ($count items)</h6>";
                        ?>
                        <h6>Delivery Charges</h6>
                        <hr>
                        <h6>Amount Payable</h6>
                    </div>
                    <div class="col-md-6">
                        <h6><?php echo "$total Rs"; ?></h6>
                        <h6 class="text-success">FREE</h6>
                        <hr>
                        <h6><?php
                            echo "$total Rs";
                            ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-2">
    <?php
        if($total!=0){
            echo "
                <form action='bill.php' method='POST'>
                    <input type='submit' class='text-success' name='Proceed to bill'>
                </form>
            ";
        }
    ?>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>

<?php

?>