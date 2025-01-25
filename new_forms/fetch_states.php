<?php
include_once 'db_connection.php';

$sql = 'SELECT state_id, state_name FROM ms_state_master';
$result = $conn->query($sql);

$data = array();
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
echo json_encode($data);

?>