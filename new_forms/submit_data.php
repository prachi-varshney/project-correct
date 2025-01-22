<?php
include_once 'db_connection.php';

$id = test_input(isset($_POST['id'])? $_POST['id']: '');
$name = test_input($_POST['name']);
$password = test_input(isset($_POST['password']) ? $_POST['password'] : "");

// if($id) {
//     $sql1 = "SELECT password1 FROM employees WHERE id = $id";
//     $result1 = $conn->query($sql1);
//     if($result1) {
//         $row = $result1->fetch_assoc();
//         $password1  = $row['password1'];
//         // echo $row['password1'];
//         if(password_verify($password1, $password)) {
//             $password = test_input($_POST['password']);
//         } else {
//             $password2 = test_input($_POST['password']);
//             $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//         }
//     }
// }


$email = test_input($_POST['email']);
$phone = test_input($_POST['phone']);
$dob = test_input($_POST['dob']);
$address = test_input($_POST['address']);
$city = test_input(intval($_POST['city']));
$state = test_input(intval($_POST['state']));
// $state_text = test_input($_POST['state_text']);
$pincode = test_input($_POST['pincode']);
$country = test_input($_POST['country']);
$experience = test_input($_POST['experience']);
$salary =test_input($_POST['salary']);

$hobbies = test_input(isset($_POST['hobbies'])? implode(", ", $_POST['hobbies']): "");
if(isset($_POST['hobbies']) && is_array($_POST['hobbies'])) {
    if(in_array("", $_POST['hobbies'])) {
        $hobbies .= " ".test_input($_POST['textInput']);
    }
}
// echo "$salary ";
// echo "$experience";



$otherhobby = test_input(isset($_POST['textInput']) ? $_POST['textInput']: '');
$gender = test_input(isset($_POST['gender']) ? $_POST['gender'] : '');
$bio = test_input($_POST['bio']);
$profile = test_input(isset($_FILES['profile']['name']) ? $_FILES['profile']['name'] : "");
$current_image = test_input($_POST['current_image']);



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$target_file = "uploads/".$_FILES['profile']['name'];
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

include_once 'validation.php';

// if(!empty($profile)) {
//     $target_dir = "uploads/";
//     $target_file = $target_dir. basename($_FILES['profile']['name']);
//     move_uploaded_file($_FILES['profile']['tmp_name'], $target_file);
// }

// if(isset($_FILES['profile'])) {
//     echo $_FILES['profile'];    
// }

if(isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['profile'];
    $image_filename = $image['name'];
    // $target_file = "uploads/".$image_filename; 
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // if (!image()) {
    //     echo json_encode($response);
    //     exit();
    // }
    // image_validate($imageFileType);
    move_uploaded_file($image['tmp_name'], "uploads/".$image_filename);
} else {
    $image_filename = $current_image;
}

// function image_validate($imageFileType) {
//     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
//         $response['success'] = false;
//         $response['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//         return false;
//     //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     //   $uploadOk = 0;
//     }   
//     return true;
// }



$response = array();

if($id && $password) {
    
    // $sql = "SELECT password FROM employees WHERE id = $id";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $saved_password = $row['password'];
    // if(password_verify($password, $saved_password)) {
    //     // $response['chkpswd'] = true;
    //     // $response['chkpswd1'] = "Password is same as last one";
    //     // echo json_encode($response);
    //     // exit("Password is same as last one");
    //     die("Password is same as last one");
    //     //die("Error executing query: " . $conn->error);    
    // } 
    // else {
    //     $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    //     $sql = 'UPDATE employees SET name=?, password=?, email=?, phone=?, dob=?, address=?, city=?, state=?, pincode=?, country=?, experience=?, salary=?, hobbies=?, gender=?, bio=?, profile=?, otherhobby = ? WHERE id=?';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param('ssssssssissssssssi', $name, $hashed_password, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby, $id);
    // }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = 'UPDATE employees SET name=?, password=?, email=?, phone=?, dob=?, address=?, city=?, state=?, pincode=?, country=?, experience=?, salary=?, hobbies=?, gender=?, bio=?, profile=?, otherhobby = ? WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssissssssssi', $name, $hashed_password, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby, $id);
} else if($id) {
    
    $sql = 'UPDATE employees SET name=?, email=?, phone=?, dob=?, address=?, city=?, state=?, pincode=?, country=?, experience=?, salary=?, hobbies=?, gender=?, bio=?, profile=?, otherhobby = ? WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssissssssssi', $name, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby, $id);
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = 'INSERT INTO employees(name, password, email, phone, dob, address, city, state, pincode, country, experience, salary, hobbies, gender, bio, profile, otherhobby) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param('ssssssssissssssss', $name, $hashed_password, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby);
}

    if($stmt->execute()) {
        $response['success'] = true;
        $response['update'] = $id ? true: false;
        $last_id = $id ? $id : $stmt->insert_id;
        $response['id'] = $last_id;
        $response['password1'] = $password;
        
        $sql1 = "SELECT e.id, e.name, e.password, e.email, e.phone, e.dob, CONCAT(e.address, ', ', d.district_name, ', ', s.state_name, ', ', e.country, ' - ', e.pincode) AS Address, e.experience, e.salary, e.hobbies, e.gender, e.bio, e.profile, e.otherhobby
        FROM employees e
        JOIN ms_district_master d ON e.city = d.district_id
        JOIN ms_state_master s ON e.state = s.state_id
        WHERE e.id = ?";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param('i', $last_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $response = array_merge($response, $result->fetch_assoc());
        }
    }
    else {
        $response['success'] = false;
        $response['error'] = "Unique value can't be used again!";
        // $response['error1'] = "Unique value Constraint";
    }
    // header('Content-Type: application/json');

    // $lastQuery = $conn->query($sql);
    // echo $sql;
    if($id) {
        $params = array($name, $password, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby, $id);
    } else {
        $params = array($name, $hashed_password, $email, $phone, $dob, $address, $city, $state, $pincode, $country, $experience, $salary, $hobbies, $gender, $bio, $image_filename, $otherhobby);
    }
    
    $final_query = $sql;
    foreach ($params as $param) {
        $final_query = preg_replace('/\?/', "'" . $conn->real_escape_string($param) . "'", $final_query, 1);
    }
    // echo $final_query;


    // $final_query = str_replace("?", "'" . $conn->real_escape_string() . "'", $sql);
    // echo "Last query executed: " . $final_query;

$stmt->close();
$conn->close();

echo json_encode($response);

?>




