<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/login.css"/>
    <link rel="stylesheet" href="assets/styles/index.css"/>
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
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['submit'])) {
        $email = stripslashes($_REQUEST['email']);    // removes backslashes
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `user` WHERE emailId ='$email'
                     AND password ='$password'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        if ($rows >= 1) {
            echo "<div class='form'>
                   <h3>You have been directed to the required page</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                   </div>";
            $userid=mysqli_fetch_assoc($result)['userId'];
            $_SESSION['userid'] = $userid;
            //Redirect to user dashboard page
            
            header("Location: registration.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <div ng-app="ngpatternApp" ng-controller="ngpatternCtrl">
    <form class="form" action = "" method="post" name="loginForm" novalidate ng-submit="sendForm()" autocomplete="off">
        <a href="index.php">
        <center><img src="assets/images/logo.png" alt="logo" height="100px" width= "250px" ></center>
        </a>
        
        <hr>
        <hr>
        <h1 class="login-title">User Login</h1>
        <input type="text" class="login-input" name="email"  ng-model="email" ng-pattern="/^[a-z|0-9|\.]{1,}(@nirmauni.ac.in)$/" placeholder="Email Address" required /><br>
        <span class="error" ng-show="loginForm.email.$error.required">*</span>
        <span class="error" ng-show="loginForm.email.$dirty&&loginForm.email.$error.pattern">Enter Correct Email</span><br>

        <input type="password" class="login-input" name="password" placeholder="Password" required /><br>

        <input type="submit" value="Login" name="submit"  class="login-button"/>
        <p class="link">Don't have an account? <a href="registration.php">Register Now</a></p>
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
