<?php
    include("auth_session_res.php");
    $resid=$_SESSION["resid"];

    $user_agent = getenv("HTTP_USER_AGENT");
    $nxt_page="download_bill";
    if(strpos($user_agent, "Mac") !== FALSE){
        $nxt_page .= "_mac";
    }
    // echo $nxt_page."<br>";
    
?>

<?php
    include('db.php');

    // Getting Name of RESTAURANT
    $sql="";
    $sql.="SELECT * FROM `restaurant` WHERE `resId` = ";
    $sql.=$resid;

    $result=mysqli_query($conn,$sql);
    $name="";
    $email="";
    $address="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["resName"];
        $email=$row["resEmailId"];
        $address=$row["resAddress"];
    } 

?>

<?php

    // All the bills
    // SELECT * FROM bill,billDetails WHERE bill.billId=billDetails.billId && bill.userId=1
    $sql="";
    $sql.="SELECT * FROM bill WHERE bill.resId = ";
    $sql.=$resid;
    $result=mysqli_query($conn,$sql);
    // $cnt=0;
    $cnt=mysqli_num_rows($result);
    // echo $cnt;
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
        <a class="navbar-brand" href="user_login.php">
            <img src="assets/images/logo.png" alt="Logo" style="max-height:60px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="res_login.php"><?php echo "$name"; ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="res_login.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="res_order.php">My Orders<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="res_profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout_res.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- <div class='container mt-2'>
  <div class='row'>
    <div class='col-md-3 col-sm-6 item'>
      <div class='card item-card card-block'>
      <img src='https://static.pexels.com/photos/262550/pexels-photo-262550.jpeg' class='img2' alt='Photo of sunset'>
      <h5 class='card-title  mt-3 mb-3'>ProVyuh</h5>
      <p class='card-text'>This is a company that builds websites, web apps and e-commerce solutions.</p> 
    </div>
  </div>
</div> -->
    <!-- <div class="container-parth">
        <br>
    </div> -->

    <?php
        while($row = mysqli_fetch_assoc($result)){
            global $conn;
            // print_r($row);
            $billid=$row["billId"];
            $userid=$row["userId"];
            $tempsql="SELECT user.user_name FROM `user` WHERE `userId` = ";
            $tempsql.=$userid;
            $username=mysqli_query($conn,$tempsql);
            $username=mysqli_fetch_assoc($username)["user_name"];
            $review=$row["review"];
            // print_r($resname);
            $date=$row["Date"];
            $billamount=$row["totalPay"];

            echo "
                <div class='mb-3' style='border:3px solid white;'>
                <div class='container-shrey mb-3 mt-3 text-light '>
                    <div class='row'>
                        <div class='col-sm text-center'>
                        BILL ID : $billid
                        </div>
                        <div class='col-sm text-center'>
                        User's Name : $username
                        </div>
                        <div class='col-sm text-center'>
                        Amount : $billamount
                        </div>
                        <div class='col-sm text-center'>
                        Date : $date
                        </div>";
            
            if($review==0){
                // Review is left
                // <a href='review_bill.php?billid=$billid' class='text-danger bg-light pl-1 pr-1'> Review</a>
                echo "
                        <div class='col-sm text-center'>
                            <a href='$nxt_page.php?billid=$billid' target='_blank' class='text-danger bg-light pl-1 pr-1'> Download Invoice </a>
                        </div>
                ";
            }
            else{
                // <a href='#' class='text-success bg-light pl-1 pr-1'> Already Reviewed</a>
                echo "
                        <div class='col-sm text-center'>
                            <a href='$nxt_page.php?billid=$billid' target='_blank' class='text-danger bg-light pl-1 pr-1'> Download Invoice </a>
                        </div>
                ";
            }

            echo "  </div>
                </div>
            ";
            //SELECT * FROM billDetails,dish WHERE billDetails.dishId=dish.DishId && billDetails.billId=1
            $tempsql="SELECT * FROM billDetails,dish WHERE billDetails.dishId=dish.DishId && billDetails.billId=";
            $tempsql.=$billid;
            $alldishes=mysqli_query($conn,$tempsql);
            // print_r($alldishes);


            echo "
                <div><div>
            ";
            $temp=0;
            while($parth = mysqli_fetch_assoc($alldishes)){
                // print_r($parth);
                $dishid=$parth["dishId"];
                // print_r($dishid);

                // dish review
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

                $quantity=$parth["Quantity"];
                $dishname=$parth["dishName"];
                $dishpic=$parth["dishPicture"];
                $dishprice=$parth["dishPrice"];
                $dishtype=$parth["dishType"];
                $v=$parth["dishVeg"];
                $temp++;
                if($temp%4==1){
                    echo "
                        </div>
                        </div>
                        <div class='container mt-4 mb-4'>
                            <div class='row d-flex justify-content-center align-items-center'>
                    ";
                }
                echo "
                    <div class='col-md-3 col-sm-6 item text-dark'>
                        <div class='card item-card card-block'>
                        <img src='assets/images/$dishpic' class='img2' alt='Photo of sunset'>
                        <table class='table text-center mt-1 mb-0'>
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
                                <th scope='row' class='text-center'>Quantity</th>
                                <td>$quantity</td>
                                </tr>
                                <tr>
                                <th scope='row' class='text-center'>Type</th>
                                <td>$dishtype</td>
                                </tr>
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
                        </div>
                    </div>
                ";
            }
            echo "</div></div></div>";
        }
    ?>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>


</html>