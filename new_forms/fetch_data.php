<?php
include_once "db_connection.php";

$sortColumn = isset($_POST['column']) ? $_POST['column'] : 'id';
$sortDirection = isset($_POST['direction']) ? $_POST['direction'] : 'ASC';

// $allowedColumns = ['id', 'name', 'phone', 'dob', 'experience', 'salary'];


// if(!in_array($sortColumn, $allowedColumns)) {
//     die("Invalid sorting column");
// }



$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 5;
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$offset = ($page - 1) * $limit;
try{
    $sql = 'SELECT COUNT(*) AS totals 
            FROM employees AS e 
            JOIN ms_district_master d ON e.city = d.district_id
            JOIN ms_state_master s ON e.state = s.state_id';
    
    $result = $conn->query($sql);
} catch(Exception $e) {
    print_r($e->getMessage());
}
if (!$result) {
    die("Error executing count query: " . $conn->error);
}
$row = $result->fetch_assoc();

$totalRecords = $row['totals'];
$totalPages = ceil($totalRecords / $limit);


$sql = "SELECT e.id, e.name, e.email, e.phone, e.dob, CONCAT(e.address, ', ', d.district_name, ', ', s.state_name, ', ', e.country, ' - ', e.pincode) AS Address, e.experience, e.salary, e.hobbies, e.gender, e.bio, e.profile 
FROM employees as e
JOIN ms_district_master d ON e.city = d.district_id
JOIN ms_state_master s ON e.state = s.state_id ORDER BY $sortColumn $sortDirection LIMIT $limit OFFSET $offset";

// $stmt = $conn->prepare($sql);
// if (!$stmt) {
//     die("Error preparing statement: " . $conn->error);
// }
// $stmt->bind_param('ii', $limit, $offset);
// $stmt->execute();
// $result = $stmt->get_result();

$result = $conn->query($sql);

$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die("Error executing query: " . $conn->error);
}

$response = array(
    'data' => $data,
    'total_pages' => $totalPages,
    'current_page' => $page,
    'offset'=> $offset
);

$conn->close();

echo json_encode($response);
?>
