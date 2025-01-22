<?php
include_once 'db_connection.php';

$id = $_POST['id'];

$response = array();

$sql = 'SELECT e.id, e.name, e.email, e.phone, e.dob, e.address, d.district_id, s.state_id, e.pincode, e.country, e.experience, e.salary, e.hobbies, e.gender, e.bio, e.profile, e.otherhobby
        FROM employees e
        JOIN ms_district_master d ON e.city = d.district_id
        JOIN ms_state_master s ON e.state = s.state_id
        WHERE e.id = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();





// $sql = 'SELECT * FROM employees WHERE id = ?';
// $stmt = $conn->prepare($sql);
// $stmt->bind_param('i', $id);
// $stmt->execute();
// $result = $stmt->get_result();

if($result->num_rows>0) {
    $response['success'] = true;
    $response['entry'] = $result->fetch_assoc();
} else {
    $response['success'] = false;
    $response['error'] = "Entry not found";
}

$conn->close();

echo json_encode($response);

?>