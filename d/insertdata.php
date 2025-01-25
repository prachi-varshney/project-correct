<?php
   include 'database.php';
  // print_r($_POST); die;
//    $user = $email = $password ="";
//    $userErr = $emailErr = $passwordErr ="";
   if($_SERVER["REQUEST_METHOD"] === "POST"){
    // validation for username
    // if(empty($_POST["name"])){
    //     $userErr = "username is required";
    // }else{
    //     $user = ($_POST["user"]);
    //      }
    // validation for email
// if(empty($_POST["email"])){
//     $emailErr = "Email is required";
//   }else {
//     $email = ($_POST["email"]);
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $emailErr = "Invalid email format";
//       }
//   }
   // validation for password
// if(empty($_POST["password"])){
//     $passwordErr = "password require";
// } else{
//     $password = ($_POST["password"]);
//         //  print_r($password); die;
// if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",$password)) {
//       $passwordErr = "should contain @Sf12";
//     }
// }
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
       $data = "";
      if(!empty($name && $email && $phone && $password)){
        $resultset_1 = mysqli_query($conn,"select * from user_master where email='".$email."' ");
        $count = mysqli_num_rows($resultset_1);
        if($count == 0){
        $sql = " INSERT INTO user_master (`email`,`password`,`name`,`phone`)
        VALUES ('$email','$password','$name','$phone')";

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
<?php
// if(isset($_POST['save']))
// {    
//      $full_name = $_POST['full_name'];
//      $email = $_POST['email'];
//      $password = $_POST['password'];
//     $resultset_1 = mysqli_query($con,"select * from login where Email='".$email."' "); 
//     $count = mysqli_num_rows($resultset_1);
//        if($count == 0)
//         {
//            $resultset_2 = mysqli_query ($con,"INSERT INTO login (Full_name,Email,Password)
//            VALUES ('$full_name','$email','$password')"); 
           
//         }else{
//            echo ("The user is already present.") ;
//         }
//     }
    ?>