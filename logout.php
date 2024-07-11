<?php
    session_start();
    if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
    {
        $_SESSION = array();
        session_destroy();
        header("Location: login_register.php");
        exit;
    } 
    else 
    {
        header("Location: login_register.php");
        exit;
    }
?>