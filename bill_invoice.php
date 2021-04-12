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
    $userid=$_SESSION["userid"];

    // Getting Name of USER
    $sql="";
    $sql.="SELECT * FROM `user` WHERE `userId` = ";
    $sql.=$userid;

    $result=mysqli_query($conn,$sql);
    $name="";

    while($row = mysqli_fetch_assoc($result)){
        $name=$row["user_name"];
    }

    $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
    $tempsql.=$userid;
    $cartid=mysqli_query($conn,$tempsql);

    if(mysqli_num_rows($cartid)==0){
        //creating new
        $tempsql="INSERT INTO `cart` (`userId`) VALUES (";
        $tempsql.=$userid;
        $tempsql.=");";
        mysqli_query($conn,$tempsql);
        $tempsql="SELECT * FROM `cart` WHERE `userId` = ";
        $tempsql.=$userid;
        $cartid=mysqli_query($conn,$tempsql);
        $cartid=mysqli_fetch_assoc($cartid)["cartId"];
    }
    else{
        // Using it
        $cartid=mysqli_fetch_assoc($cartid)["cartId"];
    }
    // echo "<center class="text-light">".$cartid."</center><br>";

    $tempsql="SELECT * FROM `cartDetail` WHERE cartId=$cartid";
    $entirecart=mysqli_query($conn,$tempsql);

?>

<?php

    if(isset($_GET["dishid"])) {
        $dishidgot=$_GET["dishid"];
        // echo "<cente r class="text-light">".$dishid."</center><br>";
        if(isset($_POST["remove"])){
            $tempsql="DELETE FROM `cartDetail` WHERE dishID=$dishidgot";
            mysqli_query($conn,$tempsql);
            echo "<script>alert('Dish is removed from Cart')</script>";
            echo "<script>window.location = './cart.php'</script>";
            exit;
        }
    }
    

?>

<?php
require('assets/mpdf/autoload.php');

// $row=mysqli_num_rows($result);
// $resid=$row["resId"];

// $temp="SELECT * FROM `restaurant` WHERE resId=$resid";
//         $temp=mysqli_query($conn,$temp);
//         $resName=mysqli_fetch_assoc($temp)["resName"];

$tempsql="SELECT * FROM `bill` WHERE billId=(SELECT MAX(billId) FROM bill)";
    $req_bill=mysqli_query($conn,$tempsql);
    $bill_arr=mysqli_fetch_assoc($req_bill);
    $billid=$bill_arr["billId"];
    $restid=$bill_arr["resId"];
    $bill_date=$bill_arr["Date"];
    // $temp="SELECT * FROM `restaurant` WHERE resId=$resid";
    // $temp=mysqli_query($conn,$temp);
    // $resName=mysqli_fetch_assoc($temp)["resName"];

    // getting res name from billid

    $tempsql="SELECT * FROM `restaurant` WHERE resId=$restid";
    $req_res=mysqli_query($conn,$tempsql);
    $res_arr=mysqli_fetch_assoc($req_res);
    $resname=$res_arr["resName"];

    $tempsql="SELECT * FROM `billdetails` WHERE billId=$billid";
    $entirecart=mysqli_query($conn,$tempsql);


$html='<style>
            .center {
                margin-left: auto;
                margin-right: auto;
            }
            .table{
                position: absolute;
                height:100%;width:100%;
            }
            td {
                text-align: left;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-bottom: 0px;
                margin-top: 0px;
            }
            </style>
        <table border=0 class="table center">';
    
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    $html.='<tr><td><img src="assets/images/logo.png" alt="Logo" style="max-height:60px;"></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    
    $html.="<tr><td><h3>Restuarant Name:</h3></td><td colspan='2'><h3>$resname</h3></td><td></td></tr>";
    $html.="<tr><td><h3>User Name:</h3></td><td colspan='2'><h3>$name</h3></td><td></td></tr>";
    $html.="<tr><td><h4>Bill ID:</h4></td><td colspan='2'><h4>$billid</h4></td><td></td></tr>";
    $html.="<tr><td><h4>Bill Date:</h4></td><td colspan='2'><h4>$bill_date</h4></td><td></td></tr>";
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';

    $html.='<tr><td><h2>Order Summary</h2></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    // $html.='<tr><td>Dish Name (xQuantity)</td><td>Price</td><td>Total Price</td></tr>';
    $html.='<tr><td>Dish Name</td><td>Quantity</td><td>Price</td><td>Total Price</td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td><tr>';

if($row=mysqli_num_rows($result)>0){

    // getting billid

    // $tempsql="SELECT MAX('billId') FROM `bill`";
    // $billid=mysqli_query($conn,$tempsql);
    
    // $cart_arr=mysqli_fetch_assoc($entirecart);

    $query = "SELECT * FROM `billdetails` WHERE billId='$billid'";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $dishid = $row["dishId"];
        $dishname = "";
        $dishprice = "";
        $quantity = $row["Quantity"];

        $sql = "SELECT * FROM `dish` WHERE DishId='$dishid'";
        $tempres = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($tempres)) {
            $dishname = $row["dishName"];
            $dishprice = $row["dishPrice"];
            $count++;
            $totalprice += $dishprice*$quantity;
            $totalquantity += $quantity;
        }

        $html.='<tr><td>'.$dishname.'</td><td>'.$quantity.'</td><td>'.$dishprice.'</td><td>'.($dishprice*$quantity).'</td></tr>';
    }

    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
	$html.='<tr><td><h2>Price Details</h2></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    $html.='<tr><td></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td>Price ('.$count.' items)</td><td>'.$totalquantity.'</td><td></td><td>'.$totalprice.'</td></tr>';
    $html.='<tr><td>Delivery charges</td><td></td><td></td><td>Free</td></tr>';
    $html.='<tr><td></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    $html.='<tr><td>Amount Payable</td><td></td><td></td><td>'.$totalprice.'</td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    $html.='</table>';
}else{
	$html="Data not found";
}
$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file=$name.time().'.pdf';
$mpdf->output($file,'D');


//D
//I
//F
//S
?>
