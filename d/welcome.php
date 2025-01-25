
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>WelcomePage</title>

    <?php include("head.php") 
    ?>

  </head>
  <body>
		<div class="wrapper d-flex align-items-stretch">
<?php include("sidebar.php") 
?>
        <!-- Page Content  -->
      <div id="content" class="p-1 p-md-3">
        <?php include("nav.php") ?>
      <div id="main-content">
 

        </div>
      </div>
		</div>
<?php include("foot.php") ?>
  