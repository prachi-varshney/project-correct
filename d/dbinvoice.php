<?php
include 'database.php';
// Insert data
// if (isset($_POST['save_student'])) {
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//     $price = $_POST['price'];
//     $dataResult = " ";
//     // File Upload
//     $uploadDirectory = "uploads/"; // Create this directory if it doesn't exist
//     $targetFile = $uploadDirectory . basename($_FILES["fileupload"]["name"]);

//     if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $targetFile)) {
//         // File was successfully uploaded

//         if (!empty($name && $description && $price)) {

//             $sql = "INSERT INTO itemmaster (`itemname`, `itemdescription`,`price`, `path`) 
// 	           VALUES ('$name','$description','$price','$targetFile')";

//             if (mysqli_query($conn, $sql)) {
//                 echo 1;
//             } else {
//                 echo 0;
//             }
//         }
//     }
// }


// loadtable 
if (isset($_POST['loadid'])) {
    $column_name = !empty($_POST['column_name']) ? $_POST['column_name'] : 'clientname';
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
        $where .=  "  and clientname LIKE '" . $_POST['name'] . "%'";
    }
    if (!empty($_POST['invoiceno'])) {
        $where .=  "  and invoiceno = '" . $_POST['invoiceno'] . "'";
    }
    if (!empty($_POST['email'])) {
        $where .= " and email = '" . $_POST['email'] . "'";
    }
    if (!empty($_POST['phone'])) {
        $where .= " and phone = '" . $_POST['phone'] . "'";
    }
    if (!empty($_POST['address'])) {
        $where .= " and address = '" . $_POST['address'] . "'";
    }

    $page = "";
    if (isset($_POST["page_no"])) {
        $page = $_POST["page_no"];
    } else {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;
    $sql = "SELECT * FROM invoice $where";
    if (!empty($column_name) && !empty($order)) {
        $sql .= " ORDER BY " . $column_name . " " . $order . " ";
    }

    if ($limit > 0) {
        $sql .= "  limit $offset, $limit";
    }


    // $auto_increment = $row[‘Auto_increment’];
    //  print_r($sql);
    // die;
    $result = mysqli_query($conn, $sql);

    $output = "";
    if (mysqli_num_rows($result) > 0) {

        $output .= '<table class="table table-sm">
    <tr class="table-secondary p-1">
    <th><a id="id" data-order="' . $order . '" href="#" onclick="sorting(this)">Id<span>' . $icon . '<span></a>
    </th>
    <th><a id="invoiceno" data-order="' . $order . '" href="#" onclick="sorting(this)">Invoice no <span>' . $icon . '<span></a>
    </th>
    <th><a id="invoicedate" data-order="' . $order . '" href="#" onclick="sorting(this)">
     Invoice Date <span>' . $icon . '</span></a>
    </th>
    <th><a id="clientname" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Client name <span>' . $icon . '</span> </a>
    </th>
    <th><a id="email" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Email <span>' . $icon . '</span> </a>
    </th>
    <th><a id="phone" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Phone <span>' . $icon . '</span> </a>
    </th>
    <th><a id="address" data-order="' . $order . '" href="#" onclick="sorting(this)">
    Address <span>' . $icon . '</span> </a>
    </th>
    <th>Edit</th>
    <th>Delete</th>
</tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<tr>
        <td>{$row["id"]}</td> 
        <td>{$row["invoiceno"]}</td>
        <td>{$row["invoicedate"]}</td>
        <td>{$row["clientname"]}</td> 
        <td>{$row["email"]}</td>
        <td>{$row["phone"]}</td>
        <td>{$row["address"]}</td>
  <td><a href='#' role='button' class='edit-btn' data-eid='{$row["id"]}' style='margin-left: 20px;' >
  <i class='fa-solid fa-pen-to-square'></i></a></td>

  <td><a href='#' role='button' class='delete-btn' data-id='{$row["id"]}' style='margin-left: 20px;'>
  <i class='fa-solid fa-trash-can' style='color: #ea2e2e;'></i></a></td> 
  </tr>";
        }
        $output .= "</table>";

        $sql_total = "SELECT * FROM invoice";
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
    $sql = "SELECT * FROM invoice where id = {$edit_id}";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
        return;
    }
}


// // Delete 
if (isset($_POST['deleteid'])) {
    $num_id = $_POST['deleteid'];
    $sql = "DELETE FROM invoice WHERE id = {$num_id}";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}


// update
if (isset($_POST['upid'])) {
    $up_id = $_POST['upid'];
    $invoiceno = $_POST['invoiceno'];
    $invoicedate = $_POST['invoicedate'];
    $clientname = $_POST['clientname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $sql = "UPDATE invoice SET invoiceno = '{$invoiceno}', invoicedate = '{$invoicedate}', clientname = '{$clientname}', email = '{$email}', phone = '{$phone}', address = '{$address}' WHERE id = {$up_id}";
    if ($result = mysqli_query($conn, $sql)) {

        echo json_encode($result);
    }
}

// autocomplete
if (isset($_POST['search'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $query = "SELECT * FROM clientmaster WHERE name like'%" . $search . "%'";
    $result = mysqli_query($conn, $query);

    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("eid" => $row['id'], "value" => $row['name'], "label" => $row['name']);
    }
    // print_r($response);

    echo json_encode($response);
}
// return data of client from clientmaster
if (isset($_POST['invoiceid'])) {
    $invoice_id = $_POST['invoiceid'];

    $query = "SELECT t1.id,t1.name,t1.email,t1.phone,t1.state,t1.city,
    CONCAT(t1.address, ' ',t2.state_name, ' ',t3.district_name) as fulladdress FROM clientmaster t1
   LEFT JOIN ms_district_master t3 ON t1.city = t3.district_id
   LEFT JOIN ms_state_master t2 ON t1.state = t2.state_id WHERE id = {$invoice_id}";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
        return;
    }
}
// autoincrement value(invoice no) 
if (isset($_POST['autoincrementvalue'])) {
    $query = "SELECT MAX(id) + 1 as id FROM invoice";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
        return;
    }
}
// autocomplete of item name from itemmaster
if (isset($_POST['searchitem'])) {
    $search = $_POST['searchitem'];
    $query = "SELECT * FROM itemmaster WHERE itemname like'%" . $search . "%'";
    $result = mysqli_query($conn, $query);
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("eid" => $row['id'], "value" => $row['itemname'], "label" => $row['itemname']);
    }
    echo json_encode($response);
}

// return data from itemmaster 
if (isset($_POST['itemid'])) {
    $item_id = $_POST['itemid'];

    $query = "SELECT * FROM itemmaster  WHERE id = {$item_id}";
    // print_r($query);
    // die;
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
        // print_r($row);
        // die;
        return;
    }
}

if (isset($_POST['searchitemra'])) {
    // print_r($_POST);
    // die;
    $search = $_POST['searchitemra'];
    $query = "SELECT * FROM itemmaster WHERE itemname like'%" . $search . "%'";
    $result = mysqli_query($conn, $query);
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("eid" => $row['id'], "value" => $row['itemname'], "label" => $row['itemname']);
    }
    echo json_encode($response);
}
mysqli_close($conn);
