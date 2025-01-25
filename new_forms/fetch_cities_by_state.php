<?php
include_once 'db_connection.php';

$state_id = isset($_POST['state_id']) ? intval($_POST['state_id']) : 0;

$cities = array();

$sql = 'SELECT district_id, district_name FROM ms_district_master WHERE state_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $state_id);
$stmt->execute();
$result = $stmt->get_result();



if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode($cities);
?>