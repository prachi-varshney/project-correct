
<?php
include("database.php");

$sql = "SELECT * FROM user_master ORDER BY name ASC";
$result = mysqli_query($conn, $sql);
$output = '';
if (mysqli_num_rows($result) > 0) {
  $output = '<table class="table table-sm">
   <tr class="table-secondary p-1">
       <th>Id</th>
       <th>Name</th>
       <th>Email</th>
       <th>Phone</th>
       <th>Edit</th>
       <th>Delete</th>
   </tr>';

  while ($row = mysqli_fetch_assoc($result)) {

    $output .= "<tr><td>{$row["id"]}</td> <td>{$row["name"]}</td> <td>{$row["email"]}</td>
<td>{$row["phone"]}</td> 
 
  <td><a href='#' role='button' class='edit-btn' data-eid='{$row["id"]}'>
  <i class='fa-solid fa-pen-to-square'></i></a></td>

  <td><a href='#' role='button' class='delete-btn' data-id='{$row["id"]}'>
  <i class='fa-solid fa-trash-can' style='color: #ea2e2e;'></i></a></td> </tr>";
  }
  $output .= "</table>";

  mysqli_close($conn);
  echo $output;
} else {
  echo 'No record found !';
}
?>