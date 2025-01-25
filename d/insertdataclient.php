<?php
   include "database.php";

   if($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
     $data = "";
    if(!empty($name && $email && $phone && $address && $state && $city)){
      $resultset_1 = mysqli_query($conn,"select * from client_master where email='".$email."' ");
      $count = mysqli_num_rows($resultset_1);
      if($count == 0){
      $sql = " INSERT INTO client_master (`name`,`email`,`phone`,`address`,`state`,`city`)
      VALUES ('$name','$email','$phone','$address','$state','$city')";

if (mysqli_query($conn, $sql)) {
  
 // $data = "Data inserted successfully!";
 echo 1;
} 
else {
  
 // $data = "Data insertion failed: ";
 echo 0;
}
}   else{
  echo ('The user is already present');
}
} echo $data; 
        
 }
mysqli_close($conn);
    ?>