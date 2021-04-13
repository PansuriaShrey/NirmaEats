<?php
    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION["userid"])) {
        echo "<script type='text/javascript'>
        alert('Please Login to the Users account.');
        </script>";
        echo "<script>window.location = './'</script>";
        exit();
    }
?>
