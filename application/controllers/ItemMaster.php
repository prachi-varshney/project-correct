<?php

defined('BASEPATH') OR exit("No direct script success allowed");

class ItemMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('data_validation');
    }

    public function index() {
        $this->load->view('item_master');
    }

    public function insertOrUpdate() {
        
        $id = $this->input->post('itemId');
        $fields = [
            'itemName' => ['Name', 'required'],
            'itemDesc' => ['Description', 'required'],
            'itemPrice' => ['Price', 'required']
        ];
        if(empty($id)) {
            $fields['itemName'] = ['Name', 'required'];
        }
        
        $result = $this->data_validation->validate($fields, 'item_master');
        if(!$result['success']) {
            echo json_encode($result);
            return;
        }

        $name = $this->input->post('itemName');
        $description = $this->input->post('itemDesc');
        $price = $this->input->post('itemPrice');
        $PreviewImgName = $this->input->post('current_image');
        $imageName = $_FILES['itemImage']['name'];

        $condition_arr = array('name'=> $name);
        $result = $this->data_validation->check_unique('item_master', $condition_arr, $id, 'id');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Item already exists!'));
            return;
        }

        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|jfif|image/png|image/x-png';
        $config['max_size'] = 200;
        $config['file_name'] = $_FILES['itemImage']['name'];

        $this->upload->initialize($config);

        if(!empty($_FILES['itemImage']['name'])) {
            if($this->upload->do_upload('itemImage')) {
                $upload_data = $this->upload->data();
                $itemImageName = $upload_data['file_name'];
            } else {
                echo json_encode(array('success' => false, 'error' => $this->upload->display_errors('', '')));
                return;
            }
        } else {
            $itemImageName = $PreviewImgName;
        }

        if(empty($id)) {
            $value_arr = array('name' => $name, 'description' => $description, 'price' => $price, 'imagepath' => $itemImageName);
            $result = $this->common_model->insertData('item_master', $value_arr);
            if($result['success']) {
                $result['update'] = false;
                echo json_encode($result);
            } else {
                echo json_encode(array('success' => false, 'error' => 'Item already exists!'));
                return;
            }
        } else {
            $statement_arr = array('name'=>$name, 'description'=> $description, 'price'=>$price, 'imagepath'=> $itemImageName);
            $condition_arr = array('id'=> $id);
            $result = $this->common_model->updateData('item_master', $statement_arr, $condition_arr);
            if($result['update']) {
                echo json_encode(array('success' => true, 'update' => true));
            }
        }
    }

    public function fetchData() {
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }

        $result = $this->common_model->getData('item_master', 'COUNT(*) AS totals');
        $total_records = $result ? $result[0]['totals'] : 0;

        $result = $this->common_model->getData('item_master', '*', '', '', $col, $direction, $limit, $offset);

        $response = array(
            'data'=> $result,
            'total_records' => $total_records
        );
        echo json_encode($response);
    }

    public function editEntry() {
        $id = $this->input->post('id');
        $condition_arr = array('id' => $id);
        $result = $this->common_model->getData('item_master', '*', $condition_arr);
        echo json_encode($result);
    }

    public function deleteItem() {
        $id = $this->input->post('id');
        $condition_arr = array('id' => $id);
        $result = $this->common_model->deleteData('item_master', $condition_arr);
        echo json_encode($result);
    }

    public function searchUser() {
        $keys = ['fName', 'fDesc', 'fPrice', 'col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }
        
        $condition_arr = array();
        if($fPrice) { $condition_arr['price'] = $fPrice;}

        $search_arr = array();
        if($fName) { $search_arr['name'] = $fName;}
        if($fDesc) { $search_arr['description'] = $fDesc;}

        $result = $this->common_model->getData('item_master', 'COUNT(*) AS totals', $condition_arr, $search_arr);
        $total_records = $result ? $result[0]['totals'] : 0;

        $result = $this->common_model->getData('item_master', '*', $condition_arr, $search_arr, $col, $direction, $limit, $offset);

        $response = array(
            'data'=> $result,
            'total_records' => $total_records
        );
        echo json_encode($response);
    }
}