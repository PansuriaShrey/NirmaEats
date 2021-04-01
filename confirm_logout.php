<?php
    session_start();
    session_unset();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Home Page
        header("Location: index.php");
    }
?>
