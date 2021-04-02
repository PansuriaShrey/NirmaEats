<?php
    include("auth_session_user.php");
    $userid=$_SESSION["userid"];
    $billid=$_GET["billid"];
?>

<?php

    // Getting USER Info.

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="NirmaEats";

    $conn = mysqli_connect($servername, $username, $password,$dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "<center class='text-light'>Connected successfully with Database</center><br>";

    $sql="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;

    $result=mysqli_query($conn,$sql);
    $name="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
    }

?>

<?php
    // Get bill details
    $sql="";
    $sql.="SELECT * FROM bill WHERE billId=$billid";
    $result=mysqli_query($conn,$sql);
    $entirerow=mysqli_fetch_assoc($result);
    // print_r($entirerow);

    // All dishes
    $sql="SELECT * FROM billDetails WHERE billId=$billid";
    $entirecart=mysqli_query($conn,$sql);
    // print_r($entirecart);
    $dishes=array();
    while($each = mysqli_fetch_assoc($entirecart)){
        $val=$each["dishId"];
        array_push($dishes,$val);
    }
    // print_r($dishes);

    // Dish details
    $dishdetails=array();
    foreach($dishes as $val){
        $sql="SELECT * FROM dish WHERE DishId=$val";
        $temp=mysqli_query($conn,$sql);
        $temp=mysqli_fetch_assoc($temp);
        array_push($dishdetails,$temp);
    }

    if(isset($_POST["rev_user"])){
        // $dishes and $_POST
        $i=0;
        foreach($dishes as $dishid){
            $stars=$_POST["gridRadios$i"];
            // echo "<center class='text-light'>$dishid and $stars</center><br>";
            $i++;
            // if dish exists
            $temp="SELECT * FROM reviewDish WHERE dishId=$dishid";
            $temp=mysqli_query($conn,$temp);
            // print_r($temp);
            if(mysqli_num_rows($temp)==0){
                // new row
                $temp="INSERT INTO `reviewDish`(`dishId`, `totalStar`, `totalReview`) VALUES ($dishid,$stars,1);";
                mysqli_query($conn,$temp);
            }
            else{
                $row=mysqli_fetch_assoc($temp);
                print_r($row);
                $totalStar=$row["totalStar"];
                $totalReview=$row["totalReview"];
                $totalStar+=$stars;
                $totalReview++;
                $temp="UPDATE `reviewDish` SET `totalStar`=$totalStar,`totalReview`=$totalReview WHERE `dishId`=$dishid";
                mysqli_query($conn,$temp);
            }
        }
        // UPDATE `bill` SET `review`=1 WHERE billId=
        $temp="UPDATE `bill` SET `review`=1 WHERE billId=$billid";
        mysqli_query($conn,$temp);

        echo "<script>alert('Thank You for your feedback')</script>";
        echo "<script>window.location = './myorder.php'</script>";
        exit;
    }

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
                <li class="nav-item ">
                <a class="nav-link" href="user_login.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="#">Review<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- details -->
    <?php
        $billamount=$entirerow["totalPay"];
        $date=$entirerow["Date"];
        $resid=$entirerow["resId"];
        $tempsql="SELECT restaurant.resName FROM `restaurant` WHERE `resId` = ";
        $tempsql.=$resid;
        $resname=mysqli_query($conn,$tempsql);
        $resname=mysqli_fetch_assoc($resname)["resName"];
        echo "
            <div class='mb-3' style='border:3px solid white;'>
            <div class='container-shrey mb-3 mt-3 text-light '>
                <div class='row'>
                    <div class='col-sm text-center'>
                    BILL ID : $billid
                    </div>
                    <div class='col-sm text-center'>
                    Restaurant : $resname
                    </div>
                    <div class='col-sm text-center'>
                    Amount : $billamount
                    </div>
                    <div class='col-sm text-center'>
                    Date : $date
                    </div>
        ";
    ?>

    <!-- form  -->
    <div class="container mt-2 mb-2">
        <form action="#" method="POST">
            <?php
                // echo "
                //     <div class=\"row\">
                //         <label for=\"inputEmail3\" class=\"col-sm-2 col-form-label\">Email</label>
                //         <div class=\"col-sm-10\">
                //                 <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios\" id=\"gridRadios1\" value=\"1\" checked>
                //                 <label class=\"form-check-label mr-5\" for=\"gridRadios1\">
                //                 1
                //                 </label>
                //                 <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios\" id=\"gridRadios2\" value=\"2\">
                //                 <label class=\"form-check-label mr-5\" for=\"gridRadios2\">
                //                 2
                //                 </label>
                //                 <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios\" id=\"gridRadios3\" value=\"3\">
                //                 <label class=\"form-check-label mr-5\" for=\"gridRadios3\">
                //                 3
                //                 </label>
                //                 <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios\" id=\"gridRadios4\" value=\"4\">
                //                 <label class=\"form-check-label mr-5\" for=\"gridRadios4\">
                //                 4
                //                 </label>
                //                 <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios\" id=\"gridRadios5\" value=\"5\">
                //                 <label class=\"form-check-label mr-5\" for=\"gridRadios5\">
                //                 5
                //                 </label>
                //         </div>
                //     </div>
                // ";
                $i=-1;
                foreach($dishdetails as $shrey){
                    $i++;
                    $dishname=$shrey["dishName"];
                    $dishpic=$shrey["dishPicture"];
                    $dishprice=$shrey["dishPrice"];
                    $dishtype=$shrey["dishType"];
                    echo "
                        <div class=\"row\">
                            <label for=\"inputEmail3\" class=\"col-sm-6 col-form-label\">
                                <div class='container mt-4 mb-4'>
                                    <div class='row d-flex justify-content-center align-items-center'>
                                        <div class='item text-dark'>
                                        <div class='card item-card card-block'>
                                        <img src='assets/images/$dishpic' class='img2' alt='Photo of sunset'>
                                        <table class='table text-center mt-1'>
                                            <thead class='thead-light'>
                                                <tr>
                                                <th scope='col' colspan='2' class='text-center font-weight-bold'>$dishname</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <th scope='row' class='text-center'>Price</th>
                                                <td>$dishprice</td>
                                                </tr>
                                                <tr>
                                                <th scope='row' class='text-center'>Type</th>
                                                <td>$dishtype</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class=\"col-sm-5 d-flex align-items-center \"><div class='w-100'>
                                    <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios$i\" id=\"gridRadios1\" value=\"1\" checked>
                                    <label class=\"form-check-label mr-5\" for=\"gridRadios1\">
                                    1
                                    </label>
                                    <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios$i\" id=\"gridRadios2\" value=\"2\">
                                    <label class=\"form-check-label mr-5\" for=\"gridRadios2\">
                                    2
                                    </label>
                                    <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios$i\" id=\"gridRadios3\" value=\"3\">
                                    <label class=\"form-check-label mr-5\" for=\"gridRadios3\">
                                    3
                                    </label>
                                    <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios$i\" id=\"gridRadios4\" value=\"4\">
                                    <label class=\"form-check-label mr-5\" for=\"gridRadios4\">
                                    4
                                    </label>
                                    <input class=\"form-check-input\" type=\"radio\" name=\"gridRadios$i\" id=\"gridRadios5\" value=\"5\">
                                    <label class=\"form-check-label mr-5\" for=\"gridRadios5\">
                                    5
                                    </label>
                            </div></div>
                        </div>
                    ";
                }
            ?>
            <!-- submit  -->
            <input type='submit' class='text-success' value='Submit Review' name="rev_user">
        </form>
    </div>

    
</body>


</html>