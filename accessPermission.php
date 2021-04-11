<?php
    session_start();
    if(isset($_SESSION["userid"])){
        echo "<script type='text/javascript'>
        alert('You are already logged In.');
        </script>";
        echo "<script>window.location = './user_login.php'</script>";
        exit();
    }
    else if(isset($_SESSION["resid"])){
        echo "<script type='text/javascript'>
        alert('You are already logged In.');
        </script>";
        echo "<script>window.location = './res_login.php'</script>";
        exit();
    }
?>