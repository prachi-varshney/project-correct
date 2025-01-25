<?php
include_once 'db_connection.php';

$id = $_GET['id'];
$response = array();

$sql = 'DELETE FROM employees WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);

if($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Entry deleted successfully";
} else {
    $response['success'] = false;
    $response['message'] = "Failed to delete!";
}

$conn->close();

echo json_encode($response);

?>