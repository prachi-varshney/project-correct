<?php
   include("database.php");

   $num_id = $_POST['id'];

   $sql = "DELETE FROM client_master WHERE id = {$num_id}";
   if(mysqli_query($conn,$sql)){
    echo 1;
   } else{
    echo 0;
   }
?>