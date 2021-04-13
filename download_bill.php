<?php
    include("auth_session_user.php");
    $userid=$_SESSION["userid"];
    $billid=$_GET["billid"];
?>

<?php

    include('db.php');

?>

<?php
    $billuserid = $billresid = "";
    $username = $resname = "";

    // Getting userid and resid from current bill
    $query = "SELECT * FROM `bill` WHERE billId='$billid'";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $billuserid = $row["userId"];
        $billresid = $row["resId"];
        $billdate = $row["Date"];
    }

    // fetching username and resname
    $query = "SELECT * FROM `user` WHERE userId='$billuserid'";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $username = $row["user_name"];
    }
    $query = "SELECT * FROM `restaurant` WHERE resId='$billresid'";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $resname = $row["resName"];
    }

?>

<?php

    $totalprice=0;
    $count=0;
    $totalquantity=0;

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
    $html.="<tr><td><h3>User Name:</h3></td><td colspan='2'><h3>$username</h3></td><td></td></tr>";
    $html.="<tr><td><h4>Bill ID:</h4></td><td colspan='2'><h4>$billid</h4></td><td></td></tr>";
    $html.="<tr><td><h4>Bill Date:</h4></td><td colspan='2'><h4>$billdate</h4></td><td></td></tr>";
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';

    $html.='<tr><td><h2>Order Summary</h2></td><td></td><td></td><td></td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td></tr>';
    // $html.='<tr><td>Dish Name (xQuantity)</td><td>Price</td><td>Total Price</td></tr>';
    $html.='<tr><td>Dish Name</td><td>Quantity</td><td>Price</td><td>Total Price</td></tr>';
    $html.='<tr><td><hr></td><td><hr></td><td><hr></td><td><hr></td><tr>';


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

    // echo $html;

    require('assets/mpdf/autoload.php');
    $mpdf=new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $file='media/'.time().'.pdf';
    $mpdf->output($file,'I');


?>