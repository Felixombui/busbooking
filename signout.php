<?php
session_start();
setcookie( 'user', $_SESSION['emailaddress'], -3600 );
session_destroy();
header( 'location:index.php' );
//include 'config.php';
?>