<?php
    session_start();
    if(!isset($_SESSION["resid"])) {
        echo "<script type='text/javascript'>
        alert('Please Login to the Restaurants account.');
        </script>";
        echo "<script>window.location = './'</script>";
        exit();
    }
?>
