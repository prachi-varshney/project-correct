<?php
require 'database.php';

header('Content-Type: application/json'); // Ensure the response is JSON


function tableList()
{

    $db = new Database();
    $query = "select * from project";
    $result = $db->getData($query);

    $html = '';


    if ($result['success'] == true) {
        $data = $result['data'];
        foreach ($data as $value) {


            $html .= '<tr><td> <a href="javascript:void(0);" style="text-decoration:none" onclick="getFromData(' . $value['id'] . ')" >#' . $value['id'] . '</a></td>';
            $html .= '<td>' . $value['name'] . '</td>';
            $html .= '<td>' . $value['email'] . '</td>';
            $html .= '<td>' . $value['phone'] . '</td>';
            $html .= '<td>
            <button class="btn btn-sm btn-primary" onclick="getFromData(' . $value['id'] . ')" >edit</button>
            <button class="btn btn-sm btn-danger" onclick="deleteData(' . $value['id'] . ')" >delete</button>
          </td>';
            $html .= '</tr>';
        }
    }

    return $html;


}


function addEditForm($post)
{
    $db = new Database();
    // print_r($post);die;
    $formData = [];
    foreach ($post as $key => $value) {
        $formData[$key] = isset($value) ? $value : '';
    }

    $id = isset($formData['id']) ? $formData['id'] : 0;
    $name = $formData['name'];
    $email = $formData['email'];
    $phone = $formData['phone'];
    $password = $formData['password'];

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name cannot be empty.";
    }

    if (empty($email)) {
        $errors[] = "Email cannot be empty.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number cannot be empty.";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be empty.";
    }

    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => implode(' ', $errors)
        ]);
        exit;
    }

    // Insert data into the database




    // $query = "INSERT INTO project (name, email, phone, password) 
    //          VALUES ('$name', '$email', '$phone', '$password')";



    if (empty($id)) {

        $query = "INSERT INTO project (name, email, phone, password) 
                     VALUES ('$name', '$email', '$phone', '$password')";

    } else {
        $query = "UPDATE project 
        SET name = '$name', email = '$email', phone= '$phone', password= '$password'
        WHERE id = '$id'";
    }


    $db_resp = $db->runQuery($query);
    if ($db_resp) {
        return array("success" => true, "message" => "Recrod saved successfully");
    } else {
        return array("success" => false, "message" => "Failed to save");
    }

}


// function getDetails($id){
// $db = new Database();
// $query = "SELECT * FROM empp WHERE id = ".$id;
// $dbresp = $db->getRowData($query);
// // print_r($dbresp);die;
// return $dbresp;
// }




// function getDetails($id)
// {
//     $db = new Database();
//     $query = "SELECT * FROM project WHERE id = " . $id;
//     try {
//         $dbresp = $db->getRowData($query);
//         return $dbresp;
//     } catch (Exception $e) {
//         return array("success" => false, "message" => $e->getMessage());
//     }
// }




function getDetails($id)
{
    $db = new Database();
    $query = "SELECT * FROM project WHERE id = " . $id;
    try {
        $dbresp = $db->getRowData($query);
        if ($dbresp) {
            return array("success" => true, "data" => $dbresp);
        } else {
            return array("success" => false, "message" => "No records found");
        }
    } catch (Exception $e) {
        return array("success" => false, "message" => $e->getMessage());
    }
}

function deleteData($id)
{
    $db = new Database();
    $query = "DELETE FROM project WHERE id = " . $id;
    return $db->runQuery($query);

}



function searchRecord($post) {
    $db = new Database();
    $name = $post['name'];
    $email = $post['email'];
    $phone = $post['phone'];

    $query = "SELECT * FROM project WHERE name LIKE '%$name%' AND email LIKE '%$email%' AND phone LIKE '%$phone%'";
    $result = $db->getData($query);

    $html = '';
    if ($result['success'] == true) {
        $data = $result['data'];
        foreach ($data as $value) {
            $html .= '<tr><td> <a href="javascript:void(0);" style="text-decoration:none" onclick="getFromData(' . $value['id'] . ')" >#' . $value['id'] . '</a></td>';
            $html .= '<td>' . $value['name'] . '</td>';
            $html .= '<td>' . $value['email'] . '</td>';
            $html .= '<td>' . $value['phone'] . '</td>';
            $html .= '<td>
            <button class="btn btn-sm btn-primary" onclick="getFromData(' . $value['id'] . ')" >edit</button>
            <button class="btn btn-sm btn-danger" onclick="deleteData(' . $value['id'] . ')" >delete</button>
          </td>';
            $html .= '</tr>';
        }
    } else {
        $html = 'No records found';
    }

    return $html;
}


// if(isset($_POST['type'])) {

// $req_type = $_POST['type'];
// unset($_POST['type']);
// $post = $_POST;
// if(!empty($req_type)){
//     if($req_type == "list"){
//         echo tableList();  
//     }else if($req_type == "addupdate"){
//        $respone = addEditForm($post);
//        echo json_encode($respone);
//     } elseif($req_type == "edit"){
//         $result = getDetails($post['id']);
//         echo json_encode(array("success"=>false, "data"=>$result));
//     }  elseif($req_type == 'delete'){
//         $result = deleteData($post['id']);
//         echo json_encode(array("success"=>true, "message"=>"Record deleted"));
//     } elseif ($req_type == 'search') {
//                     $result = searchRecord($_POST);
//                     echo $result;
//                 }
//             }
//         }


// elseif($req_type == 'searchRecord'){
//     // $name = $_POST['name'];
//     $query = "SELECT * FROM project WHERE name LIKE '%$name%' and email LIKE '%$email%' and phone LIKE '%$phone%'";
//     $result = $db->getData($query);




if (isset($_POST['type'])) {
    $req_type = $_POST['type'];
    unset($_POST['type']);
    $post = $_POST;
    if (!empty($req_type)) {
        if ($req_type == "list") {
            $limit = isset($post['limit']) ? $post['limit'] : 5;
            $offset = isset($post['offset']) ? $post['offset'] : 0;
            echo tableList($limit, $offset);
        } else if ($req_type == "addupdate") {
            $respone = addEditForm($post);
            echo json_encode($respone);
        } elseif ($req_type == "edit") {
            $result = getDetails($post['id']);
            echo json_encode(array("success" => true, "data" => $result));
        } elseif ($req_type == 'delete') {
            $result = deleteData($post['id']);
            echo json_encode(array("success" => true, "message" => "Record deleted"));
        } elseif ($req_type == 'search') {
            $result = searchRecord($post);
            echo $result;
        }
    }
}


// if (isset($_POST['type'])) {
//     $req_type = $_POST['type'];
//     $post = $_POST;
//     if (!empty($req_type)) 
//     {
//         if ($req_type == "list") {
//             $limit = isset($post['limit']) ? $post['limit'] : 10;
//             $offset = isset($post['offset']) ? $post['offset'] : 0;
//             echo tableList($limit, $offset);
//         }
//          elseif ($req_type == "addupdate") {
//             $respone = addEditForm($post);
//             echo json_encode($respone);
//         } elseif ($req_type == "edit") {
//             $result = getDetails($post['id']);
//             if ($result['success'] === true) {
//                 echo json_encode(array("success" => true, "data" => $result['data']));
//             } else {
//                 echo json_encode(array("success" => false, "message" => "No records found"));
//             }
//         } elseif ($req_type == 'delete') {
//             $result = deleteData($post['id']);
//             echo json_encode(array("success" => true, "message" => "Record deleted"));
//         } elseif ($req_type == 'search') {
//             $result = searchRecord($post);
//             echo $result;
//         }
//     }
// }




?>