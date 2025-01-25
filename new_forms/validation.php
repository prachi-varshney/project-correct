<?php
$response = array();

function validate_data() {
    global $id, $password, $name, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $profile, $imageFileType, $response;
    
    if($id) {
        if (empty($name) || empty($email) || empty($phone) || empty($dob) || empty($experience) || empty($hobbies) || empty($gender)) {
            $response['success'] = false;
            $response['error'] = "All fields with (*) are required.";
            return false;
        }
    } 
    else {
        if (empty($name) || empty($password) || empty($email) || empty($phone) || empty($dob) || empty($experience) || empty($hobbies) || empty($gender)) {
            $response['success'] = false;
            $response['error'] = "All fields with (*) are required.";
            return false;
        }
    }
    // if (empty($name) || empty($email) || empty($phone) || empty($dob) || empty($experience) || empty($hobbies) || empty($gender)) {
    //     $response['success'] = false;
    //     $response['error'] = "All fields with (*) are required.";
    //     return false;
    // }
    


    if(!preg_match('/^[a-zA-Z ]*$/', $name)) {
        $response['success'] = false;
        $response['error'] = "Only letters and white space allowed";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['error'] = "Invalid email format.";
        return false;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $response['success'] = false;
        $response['error'] = "Invalid phone number. It should be a 10-digit number.";
        return false;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        $response['success'] = false;
        $response['error'] = "Invalid date format. Use YYYY-MM-DD";
        return false;
    }

    // if (!is_numeric($experience) || $experience < 0) {
    //     $response['success'] = false;
    //     $response['error'] = "Experience must be a positive number.";
    //     return false;
    // }

    // if (!is_numeric($salary) || $salary < 0) {
    //     $response['success'] = false;
    //     $response['error'] = "Salary must be a positive number.";
    //     return false;
    // }

    if(!preg_match('/^[^0][0-9]{5}$/', $pincode)) {
        $response['success'] = false;
        $response['error'] = "Invalid pincode format";
        return false;
    }

    if($_FILES['profile']['size'] > 100000) {
        $response['success'] = false;
        $response['error'] = "Image size should be less than 500KB";
        return false;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType!="" && $imageFileType != "jfif") {
        $response['success'] = false;
        $response['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return false;
    //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //   $uploadOk = 0;
    }   

    return true;
}

if (!validate_data()) {
    echo json_encode($response);
    exit();
}


?>