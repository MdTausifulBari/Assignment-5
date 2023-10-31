<?php
session_start();

//echo "Session email: ".$_SESSION["email"]."<br/>";

if( isset( $_POST['logout'] )){
    session_destroy();
    header("Location: registration.php");
}
?>