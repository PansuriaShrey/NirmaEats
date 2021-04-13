<?php
    
    include("auth_session_user.php");
    $userid=$_SESSION["userid"];

    include('db.php');

    $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
    $tempsql.=$userid;
    $cartid=mysqli_query($conn,$tempsql);
    $cartid=mysqli_fetch_assoc($cartid)["cartId"];

    $tempsql="SELECT * FROM `cartDetail` WHERE cartId=$cartid";
    $entirecart=mysqli_query($conn,$tempsql);
    $firstrow=mysqli_fetch_assoc($entirecart);
    $resid=$firstrow["resId"];
    $entirecart=mysqli_query($conn,$tempsql);

    $total=0;
    $add_to_billdetails=array();
    while($row = mysqli_fetch_assoc($entirecart)){
        $temparray=array();
        $dishid=$row["dishId"];
        array_push($temparray,$dishid);
        $dishquantity=$row["Quantity"];
        array_push($temparray,$dishquantity);
        array_push($add_to_billdetails,$temparray);
        $tempsql="SELECT * FROM dish WHERE dishid=$dishid";
        $dish=mysqli_query($conn,$tempsql);
        $dish=mysqli_fetch_assoc($dish);
        $dishname=$dish["dishName"];
        $dishprice=$dish["dishPrice"];
        $curr=$dishquantity*$dishprice;
        $total+=$curr;
    }

    // SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "$dbname" AND TABLE_NAME = "bill";
    $tempsql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \"$dbname\" AND TABLE_NAME = \"bill\";";
    $next_bill_id=mysqli_query($conn,$tempsql);
    $next_bill_id=mysqli_fetch_assoc($next_bill_id)["AUTO_INCREMENT"];

    
    $date=date("Y/m/d");
    // echo "<center class='text-dark'>$userid and $resid and $total and $date</center><br>";
    //INSERT INTO `bill`(`billId`, `userId`, `resId`, `totalPay`, `Date`) VALUES (NULL,[value-2],[value-3],[value-4],[value-5])
    $tempsql="INSERT INTO `bill`(`billId`, `userId`, `resId`, `totalPay`, `Date`) VALUES (NULL,$userid,$resid,$total,curdate());";
    $temp=mysqli_query($conn,$tempsql);
    print_r($temp);

    // DELETE FROM `cartDetail` WHERE cartId=1
    $tempsql="DELETE FROM `cartDetail` WHERE cartId=$cartid;";
    mysqli_query($conn,$tempsql);

    // DELETE FROM `cart` WHERE cartId=3
    $tempsql="DELETE FROM `cart` WHERE cartId=$cartid;";
    mysqli_query($conn,$tempsql);

    foreach($add_to_billdetails as $col){
        $dishid=$col[0];
        $q=$col[1];
        // INSERT INTO `billDetails`(`billId`, `dishId`, `Quantity`) VALUES ([value-1],[value-2],[value-3])
        $tempsql="INSERT INTO `billDetails`(`billId`, `dishId`, `Quantity`) VALUES ($next_bill_id,$dishid,$q);";
        mysqli_query($conn,$tempsql);
        // print_r($col);
    }
    
    echo "<script>alert('Your order has been proceed')</script>";
    echo "<script>window.location = './user_login.php'</script>";
    exit;

?>