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
                <li class="nav-item active">
                <a class="nav-link" href="#">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="profile.php">My Profile</a>
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

        <!-- Search Bar -->
        <center>
            <div class="input-group w-25 col-sm-12 align-items-center" style="margin: 20%; margin-top:20px; margin-bottom:auto">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary text-light">Search</button>
            </div> 
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
        $count=mysqli_num_rows($result);
        $i=0;
        echo "<center>
            <div>
        ";
        while($row = mysqli_fetch_assoc($result)){
            $rid=$row["resId"];
            $rname=$row["resName"];
            $remail=$row["resEmailId"];
            $raddress=$row["resAddress"];
            $rtype=$row["resType"];
            $rpic=$row["resPicture"];
            $rot=$row["resOpeningTime"];
            $rct=$row["resClosingTime"];
            // echo $rname." ".$rpic;
            // echo "<center>
            //     <section id='testimonials' class='testimonials' style='width: 65%; margin: 2%;'>
            //     <div class='container'>

            //     <div class='testimonials-slider swiper-container'>
            //     <div class='swiper-wrapper'>

            //         <div class='swiper-slide'>
            //         <div class='testimonial-wrap'>
            //             <div class='testimonial-item bg-light'>
            //             <img src='assets/images/$rpic' width='200' height='200' class='testimonial-img' alt=''>
            //             <h3>$rname</h3>
            //             <h4 class='text-danger'>Email : $remail</h4>
            //             <h4>Address : $raddress</h4>
            //             <p>
            //                 Restaurant Type : $rtype<br>
            //                 Restaurant Opening Time : $rot <br>
            //                 Restaurant Closing Time :  $rct
            //             </p>
            //             </div>
            //         </div>
            //         </div>
            //     </div>
            //     </div>
            //     </div>
            //     </section><!-- End Section -->
            //     </center>";
            $i++;
            if($i%2==1){
                echo "
                    </div>
                    <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-center'>
                ";
            }
            echo "
                <div class='col mb-4 ' style='margin:2%; max-width: 30%;'>
                    <div class='card'>
                        <img src='assets/images/$rpic' width='250' height='250' class='card-img-top img2' alt='...'>
                        <div class='card-body table-responsive'>
                                <table class='table table-light w-auto'>
                                    <thead style='text-align: center;'>
                                        <tr>
                                            <th colspan=2>
                                                <a href='restaurant_dishes.php?resid=$rid&dishid=0' onclick=''>
                                                    $rname
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Email</td>
                                            <td>$remail</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>$raddress</td>
                                        </tr>
                                        <tr>
                                            <td>Timing</td>
                                            <td>From $rot to $rct</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            ";
        }
        echo "
            </div>
            </center>
        ";
    ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>


</html>