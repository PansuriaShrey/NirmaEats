<?php
    include("auth_session_user.php");
    $userid=$_SESSION["userid"];
?>

<?php

    include('db.php');

    // echo "<center class='text-dark'>Connected successfully with Database</center><br>";

    $sql="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;
    $result=mysqli_query($conn,$sql);
    $username=mysqli_fetch_assoc($result)["user_name"];

    // Cart
    $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
    $tempsql.=$userid;
    $cartid=mysqli_query($conn,$tempsql);
    $cartid=mysqli_fetch_assoc($cartid)["cartId"];
    // echo "<center class='text-dark'>$cartid</center><br>";


    // Entire Cart
    $tempsql="SELECT * FROM `cartDetail` WHERE cartId=$cartid";
    $entirecart=mysqli_query($conn,$tempsql);
    // echo "<center class='text-dark'>".mysqli_num_rows($entirecart)."</center><br>";
    $firstrow=mysqli_fetch_assoc($entirecart);
    $resid=$firstrow["resId"];
    // echo "<center class='text-dark'>$resid</center><br>";
    $entirecart=mysqli_query($conn,$tempsql);

    // Restaurant Name
    $tempsql="SELECT * FROM `restaurant` WHERE resId=$resid";
    $result=mysqli_query($conn,$tempsql);
    $resname=mysqli_fetch_assoc($result)["resName"];
    // echo "<center class='text-dark'>$resname</center><br>";

    $total=0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link href="assets/styles/cart.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <title>Bill</title>
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
                <li class="nav-item ">
                <a class="nav-link" href="#">
                    <?php echo "Hello, $username" ?>
                </a>
                </li>
                <li class="nav-item ">
                <a class="nav-link" href="user_login.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="bill.php">Bill<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex justify-content-center">
    <div class="w-75 bg-light text-dark mt-2 ml-2 mr-2 ">
        <table class="table text-center table-responsive-md mb-0">
            <thead class="thead-light">
                <tr class="">
                <th scope="col" colspan="1" style="width: 25%;">
                    <img src="assets/images/logo.png" alt="Logo" style="max-height:60px;">
                </th>
                <th scope="col" class="text-center " style="width: 25%;">
                    <?php echo date("Y-m-d");?>
                </th>
                <th scope="col" class="text-center" style="width: 25%;">
                    <?php echo date("l");?>
                </th>
                <th scope="col" class="text-center active" style="width: 25%;">
                    <?php echo $resname;?>
                </th>
                </tr>
                <!-- <div class="mt-3"></div> -->
                <tr class="">
                    <td colspan="1" class="text-center border border-danger"> Dishes </td>
                    <td colspan="1" class="text-center border border-danger"> Quantity </td>
                    <td colspan="1" class="text-center border border-danger"> Price </td>
                    <td colspan="1" class="text-center border border-danger"> # </td>
                </tr>
            </thead>
            <tbody>
                <?php
                    // entire cart
                    // dishname -- dishquantity -- dishprice -- final
                    while($row = mysqli_fetch_assoc($entirecart)){
                        $dishid=$row["dishId"];
                        $dishquantity=$row["Quantity"];
                        $tempsql="SELECT * FROM dish WHERE dishid=$dishid";
                        $dish=mysqli_query($conn,$tempsql);
                        $dish=mysqli_fetch_assoc($dish);
                        $dishname=$dish["dishName"];
                        $dishprice=$dish["dishPrice"];
                        // $dishprice
                        $curr=$dishquantity*$dishprice;
                        $total+=$curr;
                        echo "
                            <tr>
                            <td>$dishname</td>
                            <td>$dishquantity</td>
                            <td>$dishprice</td>
                            <td>$curr</td>
                            </tr>
                        ";
                    }
                    echo "
                        <tr>
                        <td colspan='3' class='text-right'>Total : </td>
                        <td>$total</td>
                        </tr>
                    ";
                ?>
                <tr>
                <td colspan='4' class='text-right'>
                <form action='' method='POST' name="pord">
                        <input type='submit' value='Place order' onclick="return SubmitForm();" >
                    </form>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

function SubmitForm()
{
    //  document.pord.action='./bill_invoice.php';
    //  document.pord.target='_blank';
    //  document.pord.submit();

     document.pord.action='./proceed.php';
     document.pord.target='';
     document.pord.submit();    
     return true;
}
</script>