<?php
    session_start();
    if(!isset($_SESSION["userid"])) {
        // echo "<script>alert('Please Login')</script>";
        header("Location: index.php");
        exit();
    }
?>
