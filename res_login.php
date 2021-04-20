<?php

    include('db.php');

?>

<?php

    include("auth_session_res.php");


    $resid=$_SESSION["resid"];

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

    // Getting all the Dishes of Restaurant
    $sql="";
    $sql.="SELECT * FROM `dish` WHERE resId=$resid";

    $result=mysqli_query($conn,$sql);

?>



<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=RocknRoll+One&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/styles/login_res.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/styles_res.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>Dashboard</title>
    <style>
        .cardbtn {
            text-decoration: none;
            background-color: brown;
            color: white;
            font-weight: 400;
            /* margin: 50px; */
            width: 100%;
        }
        .cardbtn:hover {
            text-decoration: none;
            background-color: #ba7154;
            color: white;
            font-weight: 500;
            /* transform: scale(1.01); */
            font-weight: 1000;
        }
        .card-body {
            color: brown;
        }
        .testimonial-img {
            width: 200px;
            height: 200px;
        }
        @media (max-width: 990px) {
            .testimonials .testimonial-wrap {
                padding-left: 0;
            }
            .testimonials .testimonial-item {
                padding: 10px;
                margin: 15px;
            }
            .testimonials .testimonial-item .testimonial-img {
                position: static;
                left: auto;
            }
            .testimonial-img {
            max-width: 100%;
            height: auto;
            }
        }
        .mydiv {
            margin-left: 35%;
        }
        @media (max-width: 990px) {
            .mydiv {
                margin-left: 0%;
                overflow: auto;
            }
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="res_login.php">
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
                <li class="nav-item active">
                <a class="nav-link" href="res_login.php">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="res_order.php">My Orders</a>
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

<?php

$addDishSubmit = false;
$addMulDishSubmit = false;
$removeDishSubmit = false;
$editDishApply = false;
$editDishSubmit = false;
$collapsedEdit = false;

$dishNameUp = $dishDescUp = $dishPriceUp = $dishTypeUp = $dishVegUp = $dishPicture = "";

// PHP for message alert after submit
if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["addDishSubmit"])) {
        $addDishSubmit = true;
    }
    if(isset($_POST["addMulDishSubmit"])) {
        $addMulDishSubmit = true;
    }
    if(isset($_POST["removeDishSubmit"])) {
        $removeDishSubmit = true;
    }
    if(isset($_POST["editDishApply"])) {
        $editDishApply = true;
    }
    if(isset($_POST["editDishSubmit"])) {
        $editDishSubmit = true;
    }

    function messageAlert($color, $message) {
        echo "
        <div class='alert alert-$color alert-dismissible fade show w-50 ml-auto mr-auto' role='alert'>
            <center><strong>$message</strong></center>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
    }



    if($addDishSubmit) {
        
        $resId = $GLOBALS["resid"];
        $dishName = htmlspecialchars($_POST["dishName"]);
        $dishDesc = htmlspecialchars($_POST["dishDesc"]);
        $dishPrice = htmlspecialchars($_POST["dishPrice"]);
        $dishType = htmlspecialchars($_POST["dishType"]);
        $dishVeg = htmlspecialchars($_POST["Veg"]);

        // checking if same dish exist in DB
        $query = "SELECT * FROM `dish` WHERE resId='$resId' AND dishName='$dishName'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)!=0) {
            messageAlert("danger", "Dish named $dishName already exist in Database.<br>Please Enter different Name.");
        }
        else {

            // code for storing image
            $dishPicture = $_FILES["dishPicture"];
            $fileDir = "./assets/images/";
            $tempsql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \"$dbname\" AND TABLE_NAME = \"dish\";";
            $next_dish_id=mysqli_query($conn,$tempsql);
            $next_dish_id=mysqli_fetch_assoc($next_dish_id)["AUTO_INCREMENT"];
            $fileName = "dish"."$next_dish_id";

            $getend = $_FILES['dishPicture']['name'];
            $getend = explode(".",$getend);
            $sz = count($getend);
            $ext = $getend[$sz-1];

            $fileName .= ".".$ext;

            $uploadfile = $fileDir.$fileName;
            if (move_uploaded_file($_FILES['dishPicture']['tmp_name'], $uploadfile)) {
                // messageAlert("success", "File is valid, and was successfully uploaded.\n");
            } else {
                // echo "Upload failed";
            }

            // echo "$resId, $dishName, $dishDesc, $dishPrice, $dishType, $dishVeg";

            $query = "INSERT INTO `dish` 
            (`resId`, `dishName`, `dishPicture`, `dishDesc`, `dishPrice`, `dishType`, `dishVeg`) 
            VALUES ('$resId', '$dishName', '$fileName', '$dishDesc', '$dishPrice', '$dishType', '$dishVeg');";

            if(mysqli_query($conn, $query)) {
                messageAlert("success", "1 Dish added Successfully.");
            }
            else {
                messageAlert("danger", "Error! Dish not added.");
            }
        }

    }


    if($addMulDishSubmit) {
        // messageAlert("success", "Multiple Dishes added Successfully.");

        $fileDir = "./assets/files/";
        $fileName = "tempCSV.csv";
        $uploadfile = $fileDir.$fileName;

        $getend = $_FILES['uploadfile']['name'];
        $getend = explode(".",$getend);
        $sz = count($getend);
        $ext = $getend[$sz-1];

        if($ext=="csv") {

            
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
                // messageAlert("success", "File is valid, and was successfully uploaded.\n");
            } else {
                // echo "Upload failed";   
            }



            $file = fopen($uploadfile, "r");
            $columns = NULL;
            $dishesNotAdded = "";
            $dishesNotAddedCount = 0;
            $dishesAdded = "";
            $dishesAddedCount = 0;

            $i=1;
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                if($i) {
                    $i=0;
                    continue;
                }

                $dishName = $data[1];
                if($data[0]!="" and $data[0]!="Sr No." and strlen($dishName)>=2) {

                    $query = "SELECT * FROM `dish`";
                    if(mysqli_query($conn, $query)) {
                        if(mysqli_affected_rows($conn)==0) {
                            $query = "ALTER TABLE $tablename AUTO_INCREMENT = 1";
                            mysqli_query($conn, $query);
                        }
                    }

                    $query = "SELECT * FROM `dish` WHERE resId='$resid' AND dishName='$dishName'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result)!=0) {
                        $dishesNotAddedCount++;
                        $dishesNotAdded .= "$dishName, ";
                    }
                    else {
                        $query = "INSERT INTO `dish` (resId, dishName, dishDesc, dishPrice, dishType, dishVeg)" . 
                                "VALUES ('$resid', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]')";
                        // $query = "SELECT * FROM `dish`";
                        if(mysqli_query($conn, $query)) {
                            $dishesAddedCount++;
                            $dishesAdded .= "$dishName, ";
                        }
                        else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                    

                    
                }
                
            }
            $dishesNotAdded = $dishesNotAddedCount." dishes named <br>".substr($dishesNotAdded, 0, strlen($dishesNotAdded)-2);
            $dishesNotAdded .= "<br>can't be added as they already exist in DB.";
            $dishesAdded = $dishesAddedCount." dishes named <br>".substr($dishesAdded, 0, strlen($dishesAdded)-2);
            $dishesAdded .= "<br>added successfully in DB.";
            
            messageAlert("success", $dishesAdded);
            messageAlert("danger", $dishesNotAdded);

            fclose($file);

        }
        else {
            messageAlert("danger", "Please upload CSV file only.<br>You can Download Sample CSV file also.");
        }
    }


    if($removeDishSubmit) {
        messageAlert("success", "1 Dish removed Successfully.");
    }


    if($editDishApply) {
        
        $collapsedEdit = true;
        $dishName = htmlspecialchars($_POST["dishNameUp"]);
        
        $query = "SELECT * FROM `dish` WHERE resId=$resid AND dishName='$dishName'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0) {
            while($row = mysqli_fetch_assoc($result)) {
                $_SESSION["dishIdToUpdate"] = htmlspecialchars($row["DishId"]);
                $dishNameUp = trim($row["dishName"]);
                $dishDescUp = trim($row["dishDesc"]);
                $dishPriceUp = trim($row["dishPrice"]);
                $dishPictureUp = trim($row["dishPicture"]);
                $dishTypeUp = trim($row["dishType"]);
                $dishVegUp = str_replace(' ', '', trim($row["dishVeg"]));
                
            }

        }
        else {
            messageAlert("danger", "Error! Dish named '$dishName' not found in your Menu.");
        }
        
    }
    if($editDishSubmit) {

        $dishId = $_SESSION["dishIdToUpdate"];
        unset($_SESSION["dishIdToUpate"]);
        $resId = $GLOBALS["resid"];
        $dishName = htmlspecialchars($_POST["dishNameUp"]);
        $dishDesc = htmlspecialchars($_POST["dishDescUp"]);
        $dishPrice = htmlspecialchars($_POST["dishPriceUp"]);
        $dishType = htmlspecialchars($_POST["dishTypeUp"]);
        $dishVeg = htmlspecialchars($_POST["VegUp"]);

        $dishPictureNew = "";
        $query = "SELECT dishPicture FROM `dish` WHERE DishId='$dishId'";
        $result = mysqli_query($conn, $query);
        $dishPictureOld = mysqli_fetch_assoc($result)["dishPicture"];


        if(!isset($_FILES['dishPictureUp']) || $_FILES['dishPictureUp']['error'] == UPLOAD_ERR_NO_FILE) {
    
        } else {
            $dishPictureNew = $_FILES["dishPictureUp"];
        }

        // code for storing image
        $fileName = "";
        if(!empty($dishPictureNew)) {
            
            $fileDir = "./assets/images/";
            // $tempsql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \"$dbname\" AND TABLE_NAME = \"dish\";";
            // $next_dish_id=mysqli_query($conn,$tempsql);
            // $next_dish_id=mysqli_fetch_assoc($next_dish_id)["AUTO_INCREMENT"];
            // $fileName = "dish"."$next_dish_id";
            $dish_id = $dishId;
            $fileName = "dish"."$dish_id";
            

            $getend = $_FILES['dishPictureUp']['name'];
            $getend = explode(".",$getend);
            $sz = count($getend);
            $ext = $getend[$sz-1];

            $fileName .= ".".$ext;

            $uploadfile = $fileDir.$fileName;
            if (move_uploaded_file($_FILES['dishPictureUp']['tmp_name'], $uploadfile)) {
                // messageAlert("success", "File is valid, and was successfully uploaded.\n");
            } else {
                messageAlert("danger", "Error in uploading image.");
            }
        }
        else {
            $fileName = $dishPictureOld;
        }

        // $query = "INSERT INTO `dish` 
        // (`resId`, `dishName`, `dishPicture`, `dishDesc`, `dishPrice`, `dishType`, `dishVeg`) 
        // VALUES ('$resId', '$dishName', '$fileName', '$dishDesc', '$dishPrice', '$dishType', '$dishVeg');";
        $query = "UPDATE `dish`
        SET dishName='$dishName', dishPicture='$fileName', dishDesc='$dishDesc', dishPrice='$dishPrice',
            dishType='$dishType', dishVeg='$dishVeg'
        WHERE resId=$resId AND DishId=$dishId;
        ";

        if(mysqli_query($conn, $query)) {
            messageAlert("success", "1 Dish updated Successfully.");
        }
        else {
            messageAlert("danger", "Error! Dish not updated.");
        }
    }
}


?>


<section id="testimonials" class="testimonials">
    <div class="container mt-4 mb-4">
        <div class="section-title">
            <h1 style="border: 5px solid snow"><?php echo "$name"; ?></h1>
        </div>
</div>
</section>

<!-- <br><br> -->
    <center>
    <div class="accordion" id="accordionExample" style="width: 75%">

        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                <button class="btn collapsed cardbtn text-wrap" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                1. ADD DISH
                &nbsp;<i class="fa fa-plus-square" aria-hidden="true"></i>
                </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body" style="overflow: auto">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data"> 
                    <table border='0' cellpadding="6">
                        <tr>
                            <td>Dish Name:</td>
                            <td><input style="width: 100%" type="text" name="dishName" value="" placeholder="eg. Cheese Masala Dosa, Paneer Toofani, etc."
                                 pattern="^[a-zA-Z\s\d]+$" title="eg. Cheese Masala Dosa, Paneer Toofani, etc." required></td>
                        </tr>
                        <tr>
                            <td>Dish Description:</td>
                            <td><textarea name="dishDesc" cols="40" rows="2" pattern="^[a-zA-Z\s\d]+$" title="Enter Dish Description" required></textarea></td>
                        </tr>
                        <tr>
                            <td>Dish Price:</td>
                            <td><input type="num" name="dishPrice" value="" size="40" placeholder="eg. 240, 299, etc."
                                 pattern="^[\d]+$" title="eg. 240, 299, etc." required></td>
                        </tr>
                        <tr>
                            <td>Dish Type:</td>
                            <td>
                            <select id="dishType" name="dishType" style="width: 50%" required>
                                <option value="" disabled selected>Choose Dish Type</option>
                                <option value="Salad">Salad</option>
                                <option value="Starter">Starter</option>
                                <option value="Vegetable">Vegetable</option>
                                <option value="Soup">Soup</option>
                                <option value="Snack">Snack</option>
                                <option value="Bread">Bread</option>
                                <option value="Noodles">Noodles</option>
                                <option value="SouthIndian">South Indian</option>
                                <option value="Rice">Rice & Biryani</option>
                                <option value="Pulse">Pulse</option>
                                <option value="PizzaPasta">Pizza & Pasta</option>
                                <option value="Beverage">Beverage</option>
                                <option value="Drink">Drink</option>
                                <option value="Shakes">Shakes</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Other">Other</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Dish:</td>
                            <td><input type="radio" name="Veg" value="Veg" required>Veg &nbsp; <input type="radio" name="Veg" value="NonVeg">NonVeg</td>
                        </tr>
                        <tr>
                            <td>Dish Image:</td>
                            <td><input type="file" name="dishPicture" required></td>
                        </tr>
                        <tr>
                            <td class="w-0">
                            </td>
                            <td class="d-flex justify-content-center w-75">
                            <button type="submit" name="addDishSubmit" class="btn btn-danger" style="background-color: brown">
                                Submit                               
                            </button>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                <button class="btn collapsed cardbtn text-wrap" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                2. ADD MULTIPLE DISH AT ONCE
                &nbsp;<i class="fa fa-plus-square" aria-hidden="true"></i>
                <i class="fa fa-plus-square" aria-hidden="true"></i>
                </button>
                </h5>
            </div>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body" style="overflow: auto">

                    <!-- <table></table> -->
                    <div class="mb-3">
                        <p class="mb-2">Download the CSV file and enter details in given format.</p>
                        <a href="assets/files/dish_list.csv" download>
                            <button type="button" class="btn btn-warning">
                                Download &nbsp;&nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                            </button>
                        </a>
                    </div>
                    <div>
                        <p class="mb-2">Upload the CSV file containing all dish details.</p>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                            <input class="btn btn-warning" type="file" accept=".csv" name="uploadfile" value="Upload" required>
                            <button type="submit" name="addMulDishSubmit" class="btn btn-warning">
                                    Upload&nbsp;&nbsp;<i class='fa fa-upload' aria-hidden='true'></i>                               
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                <button class="btn collapsed cardbtn text-wrap" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" disabled>
                3. REMOVE DISH
                &nbsp;<i class="fa fa-minus-square" aria-hidden="true"></i>
                &nbsp;&nbsp;(not available right now)
                </button>
                </h5>
            </div>

            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body" style="overflow: auto">
                    REMOVE DISH FORM HERE
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFour">
                <h5 class="mb-0">
                
                <button class="btn collapsed cardbtn text-wrap" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="<?php if($collapsedEdit) echo "true"; else echo "false"; ?>" aria-controls="collapseFour">
                4. EDIT DISH
                &nbsp;<i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
                </h5>
            </div>
            <div id="collapseFour" class="collapse <?php if($collapsedEdit) echo "show"; ?>" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body" style="overflow: auto">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data"> 
                    <table border='0' cellpadding="6">
                        <tr>
                            <td></td>
                            <td class="mb-6">
                            Instructions Steps >
                            <button type="button" class="btn btn-warning btn-sm" data-container="body" data-toggle="popover" data-placement="top"
                            data-content="1.Enter Dish Name.">1
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-warning btn-sm" data-container="body" data-toggle="popover" data-placement="top"
                            data-content="2.Click on Apply to fill other Details.">2
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-warning btn-sm" data-container="body" data-toggle="popover" data-placement="top"
                            data-content="3.Update Required Details.">3
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-warning btn-sm" data-container="body" data-toggle="popover" data-placement="top"
                            data-content="4.Click on Update to Update.">4
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>Change Dish Name:</td>
                            <td><input style="width: 100%" type="text" name="dishNameUp" value="<?php if(isset($dishNameUp)) echo "$dishNameUp"; ?>"
                                placeholder="eg. Cheese Masala Dosa, Paneer Toofani, etc." required></td>
                        </tr>
                        <tr>
                            <td>Change Dish Description:</td>
                            <td><textarea name="dishDescUp" cols="40" rows="2"><?php if(isset($dishDescUp)) echo "$dishDescUp"; ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Change Dish Price:</td>
                            <td><input type="num" name="dishPriceUp" value="<?php if(isset($dishPriceUp)) echo "$dishPriceUp"; ?>" size="40" placeholder="eg. 240, 299, etc."></td>
                        </tr>
                        <tr>
                            <td>Change Dish Type:</td>
                            <td>
                            <select id="dishType" name="dishTypeUp" style="width: 50%">
                                <option value="" disabled selected>Choose Dish Type</option>
                                <option value="Salad" <?php if($dishTypeUp=="Salad") echo "selected"; ?>>Salad</option>
                                <option value="Starter" <?php if($dishTypeUp=="Starter") echo "selected"; ?>>Starter</option>
                                <option value="Vegetable" <?php if($dishTypeUp=="Vegetable") echo "selected"; ?>>Vegetable</option>
                                <option value="Soup" <?php if($dishTypeUp=="Soup") echo "selected"; ?>>Soup</option>
                                <option value="Snack" <?php if($dishTypeUp=="Snack") echo "selected"; ?>>Snack</option>
                                <option value="Bread" <?php if($dishTypeUp=="Bread") echo "selected"; ?>>Bread</option>
                                <option value="Noodles" <?php if($dishTypeUp=="Noodles") echo "selected"; ?>>Noodles</option>
                                <option value="SouthIndian" <?php if($dishTypeUp=="SouthIndian") echo "selected"; ?>>South Indian</option>
                                <option value="Rice" <?php if($dishTypeUp=="Rice") echo "selected"; ?>>Rice & Biryani</option>
                                <option value="Pulse" <?php if($dishTypeUp=="Pulse") echo "selected"; ?>>Pulse</option>
                                <option value="PizzaPasta" <?php if($dishTypeUp=="PizzaPasta") echo "selected"; ?>>Pizza & Pasta</option>
                                <option value="Beverage" <?php if($dishTypeUp=="Beverage") echo "selected"; ?>>Beverage</option>
                                <option value="Drink" <?php if($dishTypeUp=="Drink") echo "selected"; ?>>Drink</option>
                                <option value="Shakes" <?php if($dishTypeUp=="Shakes") echo "selected"; ?>>Shakes</option>
                                <option value="Dessert" <?php if($dishTypeUp=="Dessert") echo "selected"; ?>>Dessert</option>
                                <option value="Other" <?php if($dishTypeUp=="Other") echo "selected"; ?>>Other</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Change Dish:</td>
                            <td><input type="radio" name="VegUp" value="Veg" <?php if(strtolower($dishVegUp)=="veg") echo "checked='checked'"; ?>>Veg &nbsp;
                                <input type="radio" name="VegUp" value="NonVeg" <?php if(strtolower($dishVegUp)=="nonveg") echo "checked='checked'"; ?>>NonVeg</td>
                        </tr>
                        <tr>
                            <td>Change Dish Image:</td>
                            <td><input type="file" name="dishPictureUp"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php if(isset($dishPictureUp)) echo "<img style='width: 150px; height: 150px;' src='./assets/images/$dishPictureUp' alt='No image found'>"; ?></td>
                        </tr>
                        <tr>
                            <td class="w-0">
                            </td>
                            <td class="d-flex justify-content-center w-50">
                            <button type="submit" name="editDishApply" class="btn btn-danger mr-3" style="background-color: brown">
                                Apply                          
                            </button><br>
                            <button type="submit" name="editDishSubmit" class="btn btn-danger" style="background-color: brown" <?php if(!$collapsedEdit) echo "disabled"; ?>>
                                Update                          
                            </button>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
        </div>

    </div>
    </center>


    <section id="testimonials" class="testimonials">
        <div class="container">
    
            <div class="section-title">
                <h1 style="border: 5px solid snow">MY DISHES</h1>
            </div>

<?php

    // $categories = array("Salad", "Starters", "Vegetable", "Dosa");
    $categories = array();

    $query = "SELECT DISTINCT(dishType) FROM `dish` WHERE resId='$resid'";
    $dishes = mysqli_query($conn, $query);
    while($rows = mysqli_fetch_assoc($dishes)) {
        array_push($categories, $rows['dishType']);
    }

    // dropdown for navigation
    echo '  <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Select Category
                <span class="caret"></span></button>
                <ul class="dropdown-menu">';
        foreach($categories as $value) {
            echo "<li><a href="."#"."$value>$value</a></li>";
        }
        echo "  </ul>
            </div> ";



    foreach($categories as $value) {

        echo "<div id='$value' class='section-title'>
                    <br><h3 style='text-align: left'>$value</h3>
                </div>";

        $query = "SELECT * FROM `dish` WHERE dishType='$value' AND resId='$resid'";

        $dishes = mysqli_query($conn, $query);

        if(mysqli_num_rows($dishes)==0) {
            echo "<h5 style='text-align: left'>No dishes found.</h5>";
        }

        echo "<div class='testimonials-slider swiper-container'><div>";
        $i=0;
        while($row = mysqli_fetch_assoc($dishes)) {
            $dishName = $row["dishName"];
            $dishPrice = $row["dishPrice"];
            $dishDesc = $row["dishDesc"];
            $dishVeg = $row["dishVeg"];
            $dishPicture = $row["dishPicture"];

            $i++;
            if($i%2) {
                echo "</div><div class='swiper-wrapper'>";
            }
            echo "
                <div style='width: 50%' class='swiper-slide'>
                <div class='testimonial-wrap'>
                    <div class='testimonial-item rounded'>
                    <div class='mydiv'>

                        <img style='color: black;' src='assets/images/$dishPicture' class='testimonial-img img-fluid' alt='&nbsp;&nbsp;&nbsp;&nbsp;No image found'>

                        <table class='table table-hover'>
                            <thead class=''>
                            <tr>
                                <th scope='col'><div class='h5 mb-0'>$dishName</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>$dishDesc</td>
                            </tr>
                            <tr>
                                <td>Rs $dishPrice /-</td>
                            </tr>
                            <tr>
                                <td>$dishVeg</td>
                            </tr>
                            </tbody>
                        </table>
         
                    </div>
                    </div>
                </div>
                </div>
            ";
        }
        echo "</div></div>";
    }
?>


        </div>
    </section><!-- End Section -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

</body>

</html>
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>