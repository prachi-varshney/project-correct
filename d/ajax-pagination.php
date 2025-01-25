<?php
include "database.php";

//$limit_per_page = 5;

$column_name = !empty($_POST['column_name']) ? $_POST['column_name'] : 'name';
// print_r($column_name); die;
$order = !empty($_POST['order']) ? $_POST['order'] : 'desc';
$icon = !empty($_POST['icon']) ? $_POST['icon'] : '<i class="fa-solid fa-arrow-down fa-2xs myclass"> </i>';
if ($order == 'desc') {
  $order = 'asc';
} else {
  $order = 'desc';
}

$limit = !empty($_POST['limit']) ? $_POST['limit'] : 5;
$where  = "Where 1=1 ";
// query for searching
if (!empty($_POST['name'])) {
  $where .=  "  and name LIKE '%" . $_POST['name'] . "%'";
}
if (!empty($_POST['email'])) {
  $where .= " and email = '" . $_POST['email'] . "'";
}
if (!empty($_POST['phone'])) {
  $where .= " and phone = '" . $_POST['phone'] . "'";
}
$page = "";
if (isset($_POST["page_no"])) {
  $page = $_POST["page_no"];
} else {
  $page = 1;
}
// offset
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM user_master $where";
// set column name and order
if (!empty($column_name) && !empty($order)) {
  $sql .= " ORDER BY " . $column_name . " " . $order . " ";
}
// limit set
if ($limit > 0) {
  $sql .= "  limit $offset, $limit";
}


// print_r($sql); die;
$result = mysqli_query($conn, $sql);

$output = "";
if (mysqli_num_rows($result) > 0) {
  $output .= '<table class="table table-sm">
    <tr class="table-secondary p-1">
    <th><a id="id" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Id<span>' . $icon . '</span></a>
    </th>
    <th><a id="name" data-order="' . $order . '" href="#" onclick="sorting(this)">
     Name <span>' . $icon . '</span></a>
    </th>
    <th><a id="email" data-order="' . $order . '" href="#" onclick="sorting(this)">
     Email <span>' . $icon . '</span></a>
    </th>
    <th><a id="phone" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Phone <span>' . $icon . '</span> </a>
    </th>
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

  $sql_total = "SELECT * FROM user_master";
  $records = mysqli_query($conn, $sql_total);
  $total_record = mysqli_num_rows($records);
  $total_pages = ceil($total_record / $limit);


 

  $output .= '<div id="pagination">
    <nav aria-label="...">
    <ul class="pagination pagination-sm">';
  for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
      $class_name = "active";
    } else {
      $class_name = "";
    }
    $output .= "<li class='page-item'><a class='{$class_name}'  id='{$i}' href=''>{$i}</a></li>";
  }
  $output .= '</ul>
    </nav> </div>';

  echo $output;
} else {
  echo "<h2>No Record Found.</h2>";
}
