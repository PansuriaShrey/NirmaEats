<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <title>Register</title>
    <link type='text/css' rel="stylesheet" href="assets/styles/login.css" />
    <link type='text/css' rel="stylesheet" href="assets/styles/index.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script type="text/javascript">
        var app = angular.module('ngpatternApp', []);
        app.controller('ngpatternCtrl', function($scope) {
            $scope.sendForm = function() {
                $scope.msg = "Form Validated";
            };

        });
    </script>
</head>

<body>
    <?php
    require('db.php');
    session_start();

    $emailID=$_SESSION["email"];

    $query  = "SELECT * FROM `user` WHERE `emailId` = '$emailID'";
    $result = mysqli_query($con, $query);
    if($result) {
        $row=mysqli_fetch_assoc($result);
        if($row["verifies"]==1){
            echo "<script type='text/javascript'>
            alert('Your account has already been verified :))');
            </script>";
            echo "<script>window.location = 'index.php'</script>";
        }
    }   

    if (isset($_REQUEST['otp'])) {
        $query  = "SELECT * FROM `user` WHERE `emailId` = '$emailID'";
        $result = mysqli_query($con, $query);
        // print_r($result);
        if ($result) {
            $row=mysqli_fetch_assoc($result);
            // print_r($row);
            if($row["OTP"]==$_REQUEST["otp"]){
                $userid= $row["userId"];
                $query = " UPDATE `user` SET `verified` = '1' WHERE `user`.`userId` = $userid; ";
                $result = mysqli_query($con, $query);
                session_unset();
                $_SESSION["userid"]=$userid;
                echo "<script type='text/javascript'>
                alert('Your account has been verified :)');
                </script>";
                echo "<script>window.location = 'user_login.php'</script>";
            }
            else{
                // include 'sendotp.php';
                // sendotp($row["emailId"],$row["user_name"],$row["OTP"]);
                echo "<div class='form'>
                <h3 class=\"alert-danger\"> You have entered Incorrect OTP </h3><br/>
                <p class='link'>Click here to <a href='otp.php'> Verify </a> again.</p>
                </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>Email ID doesnot exits in DB</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        

        <div ng-app="ngpatternApp" ng-controller="ngpatternCtrl">
            <form class="form w-25" action="" method="post" name="personForm" novalidate ng-submit="personForm.$valid &&sendForm()" autocomplete="off">
                <a href="index.php">
                    <center><img src="assets/images/logo.png" alt="logo" height="100px" width="250px"></center>
                </a>
                <hr>

                <h1 class="login-title">OTP Verification</h1>

                <div class="alert alert-success text-center">
                    We've sent a verification code to your email - <?PHP echo $_SESSION["email"]; ?>                        
                </div>

                <input type="num" class="login-input w-100 h-25"  name="otp" ng-model="otp" ng-pattern="/^([0-9]{6})$/" placeholder="Enter OTP" required /><br>
                <span class="error" ng-show="personForm.otp.$error.required">*</span>
                <span class="error" ng-show="personForm.otp.$dirty&&personForm.otp.$error.pattern">OTP Should be 6 digits</span><br>


                <input type="submit" name="submit" ng-disabled="!personForm.otp.$valid" value="Verify" class="login-button">
                <!-- <p class="link">Already have an account? <a href="login.php">Login here</a></p> -->
            </form>
        </div>
    <?php
    }
    ?>
</body>

</html>