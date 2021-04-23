<?php 

    $otpuserid = $_SESSION["userid"];

    $query = "SELECT * FROM `user` WHERE `userId` = $otpuserid";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if($row["verified"]==0){
        $_SESSION["email"]=$row["emailId"];
        echo "<script type='text/javascript'>
            alert('Your account has not been verified :(');
            </script>";
        echo "<script>window.location = 'otp.php'</script>";
        exit();
    }

?>