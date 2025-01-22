<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('data_validation');
    }

    public function index() {
        $this->load->view('user_master');
    }

    public function insertOrUpdate() {
        $id = $this->input->post('userId');

        $fields = [
            'userName' => ['Name', 'required'],
            'userEmail' => ['Email', 'required|valid_email'],
            'userPhone' => ['Phone', 'required']
        ];

        if(empty($id)) {
            $fields['userPswd'] = ['Password', 'required'];
        }

        $result = $this->data_validation->validate($fields, 'user_master');
        if (!$result['success']) {
            echo json_encode($result);
            return;
        }

        $name = $this->input->post('userName');
        $email = $this->input->post('userEmail');
        $phone = $this->input->post('userPhone');
        $password = md5($this->input->post('userPswd'));

        $condition_arr = array('email'=> $email);
        $result = $this->data_validation->check_unique('user_master', $condition_arr, $id, 'id');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Email already exists!'));
            return;
        }

        $condition_arr = array('phone'=> $phone);
        $result = $this->data_validation->check_unique('user_master', $condition_arr, $id, 'id');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Phone number already exists!'));
            return;
        }    
                
        if (empty($id)) {
            $value_arr = array('name' => $name, 'email' => $email, 'phone' => $phone, 'password' =>$password);
            $result = $this->common_model->insertData('user_master', $value_arr);

            if ($result['success']) {
                $result['update'] = false;
                echo json_encode($result);
            } else {
                echo json_encode($result);
            }
        } else {
            if($id == $this->session->userdata('id')){
                $condition_arr = array('email' => $email, 'id'=>$id);
                $result = $this->common_model->getData('user_master', 'email', $condition_arr);
                if($result!=array()) {
                    $statements_arr = ($password != NULL) ? array('name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password) : array('name' => $name, 'email' => $email, 'phone' => $phone);
                    $condition_arr = array('id' => $id);
                    $result = $this->common_model->updateData('user_master', $statements_arr, $condition_arr);
                    echo json_encode($result);
                } else {
                    echo json_encode(array('success' => false, 'error' => "Logined email can't be changed"));
                    return;
                }
            } else {
                $statements_arr = ($password != NULL) ? array('name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password) : array('name' => $name, 'email' => $email, 'phone' => $phone);
                $condition_arr = array('id' => $id);
                $result = $this->common_model->updateData('user_master', $statements_arr, $condition_arr);
                echo json_encode($result);
            }
        }
    }

    public function fetchData() {
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }

        $result = $this->common_model->getData('user_master', 'COUNT(*) AS totals');

        $total_records = $result ? $result[0]['totals'] : 0;

        $result = $this->common_model->getData('user_master', '*', '', '', $col, $direction, $limit, $offset);

        $response = array(
        'data' => $result,
        'total_records' => $total_records
        );
        echo json_encode($response);
    }

    public function deleteData() {
        $id = $this->input->post('id');
        $session_id = $this->session->userdata('id');
        if($id==$session_id) {
            $response = array('success' => false);
            echo json_encode($response);
            return;
        }
        $condition_arr = array('id' => $id);
        $result = $this->common_model->deleteData('user_master', $condition_arr);
        echo json_encode($result);
    }

    public function editEntry() {
        $id = $this->input->post('id');
        $condition_arr = array('id' => $id);
        $result = $this->common_model->getData('user_master', '*', $condition_arr);
        echo json_encode($result);
    }

    public function searchUser() {

        $name = $this->input->post('fuserName');
        $email = $this->input->post('fuserEmail');
        $phone = $this->input->post('fuserPhone');
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }

        $condition_arr = array();
        if($email) {$condition_arr['email'] = $email;}
        if($phone) {$condition_arr['phone'] = $phone;}

        $search_arr = array();
        if($name) {$search_arr['name'] = $name;}

        $result = $this->common_model->getData('user_master', 'COUNT(*) AS totals', $condition_arr, $search_arr);
        
        $total_records = $result ? $result[0]['totals'] : 0;

        $result = $this->common_model->getData('user_master', '*', $condition_arr, $search_arr, $col, $direction, $limit, $offset);
        $response = array();
            $response['data'] = $result;
            $response['total_records'] = $total_records;
        echo json_encode($response);
    }
}