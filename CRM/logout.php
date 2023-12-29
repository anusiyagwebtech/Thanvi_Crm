<?php 

// include ('require/header.php');
include ('config/config.inc.php');

// session_start();
session_destroy();
// session_unset();


 // getting current Date Time OOP way
 
 //set timeZone
 // $currentDateTime->setTimezone(new \DateTimeZone('America/New_York'));




header("location:". $sitename);
exit;
?>
