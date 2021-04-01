<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link type = 'text/css' rel="stylesheet" href="assets/styles/login.css"/>
    <link type = 'text/css' rel="stylesheet" href="assets/styles/index.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

    <script type="text/javascript">

        var app = angular.module ('ngpatternApp', []);
        app.controller('ngpatternCtrl', function ($scope) {
            $scope.sendForm = function () {
            $scope.msg = "Form Validated";
        };

        });

        </script>
</head>
<body>
<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $mobilenumber = stripslashes($_REQUEST['mobilenumber']);
        //escapes special characters in a string
        $mobilenumber = mysqli_real_escape_string($con, $mobilenumber);
        

        

        $query    = "INSERT INTO user (user_name, emailId, password, mobileNumber )"
        ."VALUES ('$username','$email','$password','$mobilenumber');";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    
    } else {
?>

<div ng-app="ngpatternApp" ng-controller="ngpatternCtrl">
    <form class="form" action="" method="post" name="personForm" novalidate ng-submit="personForm.$valid &&sendForm()" 
    autocomplete="off">
        <center><img src="assets/images/logo.png" alt="logo" height="100px" width= "250px" ></center>

        <hr>
        <hr>

            <h1 class="login-title">User Registration</h1>

                <input type="text" class="login-input" name="username" ng-model="username" 
                ng-pattern="/^[a-zA-Z\s]+$/" placeholder="Username" required /><br>
                <span class="error" ng-show="personForm.username.$error.required">*</span>
                <span class="error" ng-show="personForm.username.$dirty&&personForm.username.$error.pattern">Name Should be atleast two letters</span><br>
        

                <input type="text" class="login-input" name="email"  ng-model="email" 
                ng-pattern="/^[a-z|0-9|\.]{1,}(@nirmauni.ac.in)$/" placeholder="Email Address" required /><br>
                <span class="error" ng-show="personForm.email.$error.required">*</span>
                <span class="error" ng-show="personForm.email.$dirty&&personForm.email.$error.pattern">You need a nirmauni.ac.in account to register</span><br>


                <input type="password" class="login-input" name="password" ng-model="password" 
                ng-pattern="/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/" placeholder="Password" required /><br>
                <span class="error" ng-show="personForm.password.$error.required">*</span>
                <span class="error" ng-show="personForm.password.$dirty&&personForm.password.$error.pattern">Please Enter a strong Password</span><br>


                <input type="password" class="login-input" name="passwordcon" ng-model="passwordcon" required placeholder="Confirm Password"><br>
                <span class="error" ng-show="personForm.passwordcon.$error.required">*</span>
                <span class="error" ng-show="password != passwordcon">Passwords Dont match</span><br>


                <input type="text" class="login-input" name="mobilenumber" ng-model="mobilenumber" ng-pattern="/^([0-9]{10})$/"  placeholder="Mobile number" required /><br>
                <span class="error" ng-show="personForm.mobilenumber.$error.required">*</span>
                <span class="error" ng-show="personForm.mobilenumber.$dirty&&personForm.mobilenumber.$error.pattern">Mobile Number Should be 10 digits</span><br>


                <input type="submit" name="submit" value="Register" class="login-button">
                <p class="link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
<?php
    }
?>
<footer>
      <p>
         By: Aakash Shah | Parth Shah | Shivam Ajudia | Shrey Pansuria
      </p>
   </footer>
</body>
</html>
