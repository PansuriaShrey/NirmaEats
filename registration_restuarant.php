<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Restaurant Registration</title>
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

        function atLeastOneCheckboxIsChecked()
        {
            const checkboxes = Array.from(document.querySelectorAll(".checkbox"));
            return checkboxes.reduce((acc, curr) => acc || curr.checked, false);
        }

    </script>

</head>
<body>
<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['resName'])) {
        // removes backslashes
        
        $resName = $_REQUEST['resName'];
        $resEmailId = $_REQUEST['resEmailId'];
        $resAddress = $_REQUEST['resAddress'];
        $resType_f = $_REQUEST['resType'];
        $resType = "";
        foreach ($resType_f as $color){ 
            $resType .= $color;
            $resType .= "/";
        }
        if(strlen($resType)>0){
            substr_replace($resType, "", -1);
        }

        // Image File Location
        // $resPicture = $_REQUEST['resPicture'];
        $uploaddir="./assets/images/";
        $tempsql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \"NirmaEats\" AND TABLE_NAME = \"restaurant\";";
        $next_res_id=mysqli_query($con,$tempsql);
        $next_res_id=mysqli_fetch_assoc($next_res_id)["AUTO_INCREMENT"];
        $getend=$_FILES['resPicture']['name'];
        print_r($_FILES['resPicture']);
        // print_r($getend);
        // echo "<br>";
        $getend=explode(".",$getend);
        $sz=count($getend);
        $last="";
        $last=$getend[$sz-1];
        // print_r($last);
        $filename="res".$next_res_id.".".$last;
        // print_r($filename);
        // echo "<br>";
        $uploadfile=$uploaddir.$filename;

        if (move_uploaded_file($_FILES['resPicture']['tmp_name'], $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "Upload failed a".$_FILES["resPicture"]["error"];
            echo file_put_contents($uploadfile, 'testing_writing_to_file');
        }

        $resOpeningTime = $_REQUEST['resOpeningTime'];
        $resClosingTime = $_REQUEST['resClosingTime'];
        $password = $_REQUEST['password'];

        // echo $resName;
        // echo $resEmailId;
        // echo $resAddress;
        // echo $resType;
        // echo $resOpeningTime;
        // echo $resClosingTime;
        // echo $password;

        $query = "INSERT INTO restaurant "
        ."(resName, resEmailId, resAddress, resType, resPicture, resOpeningTime, resClosingTime, password) VALUES "
        ."('$resName', '$resEmailId', '$resAddress', '$resType', '$filename', '$resOpeningTime', '$resClosingTime', '$password');";

        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login_restaurant.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Query wasnt updated.</h3><br/>
                  <p class='link'>Click here to <a href='login_restaurant.php'>registration</a> again.</p>
                  </div>";
        }
    
    } else {
?>
    <div ng-app="ngpatternApp" ng-controller="ngpatternCtrl">
    <form class="form" action="" method="post" name="restaurantForm" novalidate ng-submit="restaurantForm.$valid &&sendForm()" enctype="multipart/form-data"
    autocomplete="off">
        <center><img src="assets/images/logo.png" alt="logo" height="100px" width= "250px" ></center>
        <hr>
        <hr>
            <h1 class="login-title">Restaurant Registration</h1>

                <input type="text" class="login-input" name="resName" ng-model="resName" 
                ng-pattern="/^([a-z]|[A-Z]){2,}$/" placeholder="Restaurant Name" required /><br>
                <span class="error" ng-show="restaurantForm.resName.$error.required">*</span>
                <span class="error" ng-show="restaurantForm.resName.$dirty&&restaurantForm.resName.$error.pattern">Restaurant Name Should be atleast two letters</span><br>

                <input type="text" class="login-input" name="resEmailId" ng-model="resEmailId" 
                ng-pattern="/^[a-z|0-9|\.]{1,}(@)[a-z|0-9|\.]{1,}(\.){1,}[a-z|0-9|\.]{1,}$/" placeholder="Email Address" required /><br>
                <span class="error" ng-show="restaurantForm.resEmailId.$error.required">*</span>
                <span class="error" ng-show="restaurantForm.resEmailId.$dirty&&restaurantForm.resEmailId.$error.pattern">Enter a correct email address</span><br>

                <fieldset class="field_set">
                    <span>Enter Restaurant Address</span>
                    <hr>
                    <textarea name="resAddress" class="login-area" rows="6" cols="35" ng-model="resAddress" placeholder="XYZ...Besides Nirma University" required/>
                    </textarea><br>
                </fieldset>
                <span class="error" ng-show="restaurantForm.resAddress.$error.required">*</span><br>

                <fieldset class="field_set">
                <span>Select the type of your Restaurant</span>
                <hr>
                 <table width=100%>
                    <tr>
                        <td style="margin-left: 0px">
                            <center>
                                Beverage
                            </center>
                        </td>
                        <td style="margin-right: 0px">
                            <center>
                                Breakfast       
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td style="margin-left: 0px">
                            <center>
                            <input type="checkbox" class="login-input" name="resType[]" value="Beverage">
                            </center>
                        </td>
                        <td>
                            <center>
                            <input type="checkbox" class="login-input" id="Breakfast" name="resType[]" value="Breakfast">
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                        </td>
                        <td>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <center>
                                Lunch
                        </center>
                        </td>
                        <td>
                            <center>
                                Dinner
                        </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                            <input type="checkbox" class="login-input" id="Lunch" name="resType[]" value="Lunch">
                            </center>
                        </td>
                        <td>
                            <center>
                            <input type="checkbox" class="login-input" id="Dinner" name="resType[]" value="Dinner">
                            </center>
                        </td>
                    </tr>
                 </table>
                </fieldset>  
                <span id = "cb" class="error">* <?php echo $mobileErr;?></span><br></center>

                <fieldset class="field_set">
                <span>Upload a Picture</span>
                <hr>
                <input type="file" name="resPicture" ng-model="resPicture" class="login-input" required/><br>
                </fieldset>
                <span class="error" ng-show="restaurantForm.resPicture.$error.required">*</span><br>

                <fieldset class="field_set">
                    <span>Opening Time</span>
                    <hr>
                    <input type="time" class="login-input" name="resOpeningTime">
                    <span>Closing Time</span>
                    <hr>
                    <input type="time" class="login-input" name="resClosingTime">
                </fieldset>
                <span class="error">* <?php echo $mobileErr;?></span><br></center>   

                <input type="password" class="login-input" name="password" ng-model="password" 
                ng-pattern="/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/" placeholder="Password" /required><br>
                <span class="error" ng-show="restaurantForm.password.$error.required">*</span>
                <span class="error" ng-show="restaurantForm.password.$dirty&&restaurantForm.password.$error.pattern">Please Enter a strong Password</span><br>

                <input type="password" class="login-input" name="passwordcon" ng-model="passwordcon" required placeholder="Confirm Password"><br>
                <span class="error" ng-show="restaurantForm.passwordcon.$error.required">*</span>
                <span class="error" ng-show="password != passwordcon">Passwords Dont match</span><br>
        
                <input type="submit" name="submit" value="Register" class="login-button">
                <p class="link">Already have an account? <a href="login_restaurant.php">Login here</a></p>

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
