<?php
    session_start();
    if(!isset($_SESSION["resid"])) {
        // echo "<script>alert('Please Login')</script>";
        header("Location: index.php");
        exit();
    }
?>
