<?php
include "database.php";
// $sql = "CREATE DATABASE main";
//    if(mysqli_query($conn,$sql)){
//     echo "Database created successfully";
//    } else{
//        echo "Error creating database: " .mysqli_error($conn);
//    }

// $sql = "CREATE TABLE logindata (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     email VARCHAR(50),
//     password VARCHAR(20)
//    )";

// $sql = "CREATE TABLE client_master (
//   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//   name VARCHAR(30),
//   email VARCHAR(30),
//   phone VARCHAR(20),
//   address VARCHAR(50),
//   state VARCHAR(40),
//   city VARCHAR(40)
//  )";      

// $sql = "CREATE TABLE item_master (
//   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//   itemname VARCHAR(20),
//   itemdescription VARCHAR(30),
//   price VARCHAR(30)

//  )";

$sql = "CREATE TABLE invoice (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  invoiceno int,
  invoicedate DATE,
  clientname VARCHAR(30),
  email VARCHAR(30),
  phone VARCHAR(15),
  address VARCHAR(50)
 
 )";

if (mysqli_query($conn, $sql)) {
  echo "Table user_master created successfully";
} else {
  echo "Error creating: " . mysqli_error($conn);
}
mysqli_close($conn);
