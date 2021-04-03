<?php
    
    include("auth_session_user.php");
    $userid=$_SESSION["userid"];

    $resid=1;
    $_SESSION["resid"]=$_GET["resid"];
    $resid=$_SESSION["resid"];
    // echo "<center class='text-light'>$resid</center><br>";

?>

<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="NirmaEats";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "<center class='text-light'>Connected successfully with Database</center><br>";

    // Getting USER Info.
    $sql="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;
    $result=mysqli_query($conn,$sql);
    $name="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
    }

    $dishid=$_GET["dishid"];

    if(isset($_POST["quantity"])){
        // echo "<center class='text-light'>".$_POST["quantity"]."</center><br>";
        $quantity=$_POST["quantity"];

        // Get CartID
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

        // Check if the user has dishes from different restaurant
        if(mysqli_num_rows($entirecart)>0){
            $tempresid=mysqli_fetch_assoc($entirecart)["resId"];
            if($tempresid!=$resid){
                echo "<script>alert('You have dishes from different restaurant in your cart')</script>";
                echo "<script>window.location = './restaurant_dishes.php?resid=$resid&dishid=0'</script>";
                exit;
            }
        }

        $tempsql="SELECT * FROM `cartDetail` WHERE cartId=$cartid";
        $entirecart=mysqli_query($conn,$tempsql);
        // Check if dish already exits
        $exists=0;
        while($row=mysqli_fetch_assoc($entirecart)){
            // print_r($row);
            if($dishid==$row["dishId"]){
                $exists=1;
            }
        }
        if($exists){
            // go back to restaurant_dishes pge
            echo "<script>alert('Error : Dish is already added to the cart..!')</script>";
            echo "<script>window.location = './restaurant_dishes.php?resid=$resid&dishid=0'</script>";
            exit;
        }
        else{
            //add to cart
            $tempsql="INSERT INTO `cartDetail`(`cartId`, `userId`, `dishId`, `resId`, `Quantity`) VALUES ($cartid,$userid,$dishid,$resid,$quantity)";
            mysqli_query($conn,$tempsql);
            echo "<script>alert('Dish is added in the cart')</script>";
            echo "<script>window.location = './restaurant_dishes.php?resid=$resid&dishid=0'</script>";
            exit;
        }
    }

?>

<?php

    $tempsql="SELECT restaurant.resName FROM `restaurant` WHERE `resId` = ";
    $tempsql.=$resid;
    $resname=mysqli_query($conn,$tempsql);
    $resname=mysqli_fetch_assoc($resname)["resName"];

    // SELECT * FROM `dish` WHERE `resId` = 1
    $sql="SELECT * FROM `dish` WHERE `resId` = ";
    $sql.=$resid;
    $dishes=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="assets/styles/myorder.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>My Orders</title>
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
                <li class="nav-item active">
                <a class="nav-link" href="user_login.php">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                <a class="nav-link" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item ">
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

    <div class='mb-3' style='border:3px solid white;'>
        <div class='container mb-3 mt-3 text-light'>
            <div class='row'>
                <div class='col-sm text-center'>
                    Restaurant : <?php echo $resname; ?>
                </div>
            </div>
        </div>
    </div>

    <?php 
        $temp=0;
        while($shrey = mysqli_fetch_assoc($dishes)){
            // print_r($shrey);
            $dishname=$shrey["dishName"];
            $dishpic=$shrey["dishPicture"];
            $dishprice=$shrey["dishPrice"];
            $dishtype=$shrey["dishType"];
            $dishdesc=$shrey["dishDesc"];
            $v=$shrey["dishVeg"];
            $dishid=$shrey["DishId"];

            $sqltemp="SELECT * FROM reviewDish WHERE dishId=$dishid";
            $sqltemp=mysqli_query($conn,$sqltemp);
            // print_r($temp);
            if(mysqli_num_rows($sqltemp)==0){
                $totalStar=0;
                $totalReview=0;
                $percent=0;
            }
            else{
                $row=mysqli_fetch_assoc($sqltemp);
                // print_r($row);
                $totalStar=$row["totalStar"];
                $totalReview=$row["totalReview"];
                $percent=($totalStar/$totalReview);
                $percent*=20;
                $percent=(int)$percent;
                // print_r($percent);
            }

            $temp++;
            if($temp%4==1){
                echo "
                    </div>
                    </div>
                    <div class='container mt-4 mb-4'>
                        <div class='row d-flex justify-content-center align-items-center'>
                ";
            }
            if($v=="Veg"){
                echo "
                <div class='col-md-3 col-sm-6 item text-dark'>
                    <div class='card item-card card-block'>
                    <img src='assets/images/$dishpic' class='img2' alt='Photo of sunset'>
                    <h5 class='card-title  mt-3 mb-3 text-success'>$dishname</h5>
                    <table class='table text-center mb-0'>
                            <tbody>
                                <tr>
                                <th scope='row' class='text-center'>Desc</th>
                                <td>$dishdesc</td>
                                </tr>
                                <tr>
                                <th scope='row' class='text-center'>Price</th>
                                <td>$dishprice</td>
                                </tr>
                                <tr>
                                <tr>
                                <td colspan=2>
                                    <div class=\"progress\">
                                        <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: $percent%\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\">
                                        <small class=\"justify-content-center d-flex position-absolute w-100 text-light\"> $percent% ($totalReview Reviews) </small>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                    </table>
                    <form action='./restaurant_dishes.php?resid=$resid&dishid=$dishid' method='POST'>
                        Quantity: <input type='number' name='quantity'><br>
                        <input type='submit' value='Add to cart'>
                    </form>
                </div>
                </div>
                ";
            }
            else{
                echo "
                <div class='col-md-3 col-sm-6 item text-dark'>
                    <div class='card item-card card-block'>
                    <img src='assets/images/$dishpic' class='img2' alt='Photo of sunset'>
                    <h5 class='card-title  mt-3 mb-3 text-danger'>$dishname</h5>
                    <table class='table text-center mb-0'>
                            <tbody>
                                <tr>
                                <th scope='row' class='text-center'>Desc</th>
                                <td>$dishdesc</td>
                                </tr>
                                <tr>
                                <th scope='row' class='text-center'>Price</th>
                                <td>$dishprice</td>
                                </tr>
                                <td colspan=2>
                                    <div class=\"progress\">
                                        <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: $percent%\" aria-valuenow=\"$percent\" aria-valuemin=\"0\" aria-valuemax=\"100\">
                                        <small class=\"justify-content-center d-flex position-absolute w-100 text-light\"> $percent% ($totalReview Reviews) </small>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                    </table>
                    <form action='./restaurant_dishes.php?resid=$resid&dishid=$dishid' method='POST'>
                        Quantity: <input type='number' name='quantity'><br>
                        <input type='submit' value='Add to cart'>
                    </form>
                </div>
                </div>
                ";
            }
        }
        echo "</div></div></div>";
    ?>

    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>
