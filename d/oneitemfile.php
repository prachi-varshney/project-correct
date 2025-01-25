<?php
include 'database.php';
// Insert data
if (isset($_POST['save_student'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $dataResult = " ";
  // File Upload
  $uploadDirectory = "uploads/"; // Create this directory if it doesn't exist
  $targetFile = $uploadDirectory . basename($_FILES["fileupload"]["name"]);

  if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $targetFile)) {
    // File was successfully uploaded

    if (!empty($name && $description && $price)) {

      $sql = "INSERT INTO item_master (`item_name`, `item_description`,`price`, `path`) 
	           VALUES ('$name','$description','$price','$targetFile')";

      if (mysqli_query($conn, $sql)) {
        echo 1;
      } else {
        echo 0;
      }
    }
  }
}


// loadtable 
if (isset($_POST['loadid'])) {
  $column_name = !empty($_POST['column_name']) ? $_POST['column_name'] : 'item_name';
  // print_r($column_name); die;
  $order = !empty($_POST['order']) ? $_POST['order'] : 'desc';
  $icon = !empty($_POST['icon']) ? $_POST['icon'] : '<i class="fa-solid fa-arrow-down fa-2xs myclass">
    </i>';
  if ($order == 'desc') {
    $order = 'asc';
  } else {
    $order = 'desc';
  }

  $limit = !empty($_POST['limit']) ? $_POST['limit'] : 5;
  $where  = "Where 1=1 ";
  if (!empty($_POST['name'])) {
    $where .=  "  and item_name LIKE '" . $_POST['name'] . "%'";
  }

  $page = "";
  if (isset($_POST["page_no"])) {
    $page = $_POST["page_no"];
  } else {
    $page = 1;
  }

  $offset = ($page - 1) * $limit;
  $sql = "SELECT * FROM item_master $where";
  if (!empty($column_name) && !empty($order)) {
    $sql .= " ORDER BY " . $column_name . " " . $order . " ";
  }

  if ($limit > 0) {
    $sql .= "  limit $offset, $limit";
  }

  $result = mysqli_query($conn, $sql);

  $output = "";
  if (mysqli_num_rows($result) > 0) {
    $output .= '<table class="table table-sm">
    <tr class="table-secondary p-1">
<th><a id="id" data-order="' . $order . '" href="#" onclick="sorting(this)">Id<span>' . $icon . '<span></a>
</th>
<th><a id="item_name" data-order="' . $order . '" href="#" onclick="sorting(this)">Item Name <span>' . $icon . '<span></a>
    </th>
    <th><a id="itemdescription" data-order="' . $order . '" href="#" onclick="sorting(this)">
     Item Description <span>' . $icon . '</span></a>
    </th>
    <th><a id="price" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Price <span>' . $icon . '</span> </a>
    </th>
    <th><a id="path" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Path <span>' . $icon . '</span> </a>
    </th>
    <th>Edit</th>
    <th>Delete</th>
</tr>';
    while ($row = mysqli_fetch_assoc($result)) {
      $output .= "<tr>
        <td>{$row["id"]}</td> 
        <td>{$row["item_name"]}</td>
        <td>{$row["item_description"]}</td>
        <td>{$row["price"]}</td> 
        <td><img style='width:50px';  src='{$row["path"]}'/></td> 

  <td><a href='#' role='button' class='edit-btn' data-eid='{$row["id"]}' style='margin-left: 20px;' >
  <i class='fa-solid fa-pen-to-square'></i></a></td>

  <td><a href='#' role='button' class='delete-btn' data-id='{$row["id"]}' style='margin-left: 20px;'>
  <i class='fa-solid fa-trash-can' style='color: #ea2e2e;'></i></a></td> 
  </tr>";
    }
    $output .= "</table>";

    $sql_total = "SELECT * FROM item_master";
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
}


// return data 
if (isset($_POST['id'])) {
  $edit_id = $_POST['id'];
  $sql = "SELECT * FROM item_master where id = {$edit_id}";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
    return;
  }
}


// Delete 
if (isset($_POST['deleteid'])) {
  $num_id = $_POST['deleteid'];
  $sql = "DELETE FROM item_master WHERE id = {$num_id}";
  if (mysqli_query($conn, $sql)) {
    echo 1;
  } else {
    echo 0;
  }
}


// update
if (isset($_POST['upid'])) {
  $up_id = $_POST['upid'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  // file upload steps 
  $temp_name = '';
  $folder = 'uploads/';
  $image_file = $_FILES['fileupload']['name'];
  $file = $_FILES['fileupload']['tmp_name'];
  $path = $folder . $image_file;
  $target_file = $folder . basename($image_file);
  $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
  // ALLOW ONLY JPG,JPEG,GIF AND PNG ETC.
  if ($file != '') {
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "png") {
      $error[] = 'only jpg,jpeg,png and gif file allow';
    }
    if ($_FILES['fileupload']['size'] > 1048576) {
      $error[] = 'sorry,image size too large';
    }
  }
  if (!isset($error)) {
    if ($file != '') {
      move_uploaded_file($file, $target_file);

      $sql = "UPDATE item_master SET item_name = '{$name}', item_description = '{$description}', price = '{$price}', path = '{$target_file}' WHERE id = {$up_id} ";
    } else {
      $sql = "UPDATE item_master SET item_name = '{$name}', item_description = '{$description}', price = '{$price}' WHERE id = {$up_id} ";
    }
    if ($result = mysqli_query($conn, $sql)) {
      echo json_encode($result);
    }
  }
}

mysqli_close($conn);
