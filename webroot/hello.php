<?php
session_start();


$_SESSION['asd'] = array();

$testing = "nej";

$_SESSION['asd'[$testing]] = "Hej";

print($_SESSION);



?>

