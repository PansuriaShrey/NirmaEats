<?php
    include 'db.php';
    session_start();
    $emailID=$_SESSION["email"];
    $query  = "SELECT * FROM `user` WHERE `emailId` = '$emailID'";
    $result = mysqli_query($con, $query);

    if($result) {
        $row=mysqli_fetch_assoc($result);
        $num = rand(100000,999999);
        $userID = $row["userId"];
        $query = "UPDATE `user` SET `OTP` = '$num' WHERE `user`.`userId` = $userID";
        $result = mysqli_query($con, $query);
        include 'sendotp.php';
        sendotp($emailID,$row["user_name"],$num);
    }  

    echo "<script>window.location = 'otp.php'</script>";
?>