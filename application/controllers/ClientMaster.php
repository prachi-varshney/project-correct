<?php
defined('BASEPATH') OR exit('No direct script success allowed');

class ClientMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('data_validation');
    }
    
    public function index() {
        $this->load->view('client_master');
    }
//insert or update data
    public function insertOrUpdate() {

        $fields = [
            'cName' => ['Name', 'required|trim'],
            'cEmail' => ['Email', 'required|valid_email'],
            'cPhone' => ['Phone', 'required|exact_length[10]|numeric'],
            'cAddress' => ['Address', 'required'],
            'cState' => ['State', 'required'],
            'cCity' => ['City', 'required'],
            'cPincode' => ['Pincode', 'required|exact_length[6]|numeric']
        ];

        $result = $this->data_validation->validate($fields, 'client_master');
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }

        $keys = ['id', 'name', 'email', 'phone', 'address', 'state', 'city', 'pincode'];
        $i = 0;
        $post = $this->input->post();
        foreach($post as $key => $value) {
            if($i<8) {
            $x = $keys[$i];
            $$x =  (empty($value) ? '' : $value);
            $i++;
            } 
        }
        
        $condition_arr = array('email'=> $email);
        $result = $this->data_validation->check_unique('client_master', $condition_arr, $id, 'id');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Email already exists!'));
            exit;
        }

        $condition_arr = array('phone'=> $phone);
        $result = $this->data_validation->check_unique('client_master', $condition_arr, $id, 'id');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Phone number already exists!'));
            exit;
        }

        if(empty($id)) {
            $value_arr = array('name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'state' => $state, 'city' => $city, 'pincode' => $pincode);
            $result = $this->common_model->insertData('client_master', $value_arr);

            if($result['success']) {
                $result['update'] = false;
                echo json_encode($result);
            } else {
                echo json_encode($result);
            }

        } else {
            $statement_arr = array('name'=>$name, 'email'=>$email, 'phone'=>$phone, 'address'=>$address, 'state'=> $state, 'city'=>$city, 'pincode'=>$pincode);
            $condition_arr = array('id'=> $id);
            $result = $this->common_model->updateData('client_master',$statement_arr, $condition_arr);
            echo json_encode($result);
        }     
    }

// load client data
    public function fetchData() {
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }
        $result = $this->common_model->getData('client_master', 'COUNT(*) AS totals');
        $total_records = $result ? $result[0]['totals'] : 0;
        $join_table = ['ms_district_master AS d', 'ms_state_master AS s'];
        $join_condition = array('c.city'=>'d.district_id', 'c.state' => 's.state_id');

        $result = $this->common_model->getData("client_master AS c","c.id, c.name, c.email, c.phone, CONCAT(c.address, ', ', d.district_name, ', ', s.state_name, ' - ', c.pincode) AS Address", "", "", $col, $direction, $limit, $offset, $join_table, $join_condition);

        $response = array(
            'data' => $result,
            'total_records' => $total_records
        );
        echo json_encode($response);
    }

// fetch client data for update
    public function editEntry() {
        $id =  $this->input->post('id');
        $condition_arr = array('id'=>$id);
        $result = $this->common_model->getData('client_master', '*', $condition_arr);
        echo json_encode($result);
    }

// delete client data
    public function deleteData() {
        $id = $this->input->post('id');
        $condition_arr = array('id'=>$id);
        $result = $this->common_model->deleteData('client_master', $condition_arr);
        echo json_encode($result);
    }

// search client
    public function searchUser() {
        $name = $this->input->post('fclientName');
        $email = $this->input->post('fclientEmail');
        $phone = $this->input->post('fclientPhone');
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }
        
        $condition_arr = array();
        if($email) {$condition_arr['email'] = $email;}
        if($phone) {$condition_arr['phone'] = $phone;}

        $search_arr = array();
        if($name) {$search_arr['name'] = $name;}

        $result = $this->common_model->getData('client_master', 'COUNT(*) AS totals', $condition_arr, $search_arr);
        $total_records = $result ? $result[0]['totals'] : 0;

        $join_table = ['ms_district_master AS d', 'ms_state_master AS s'];
        
        $join_condition = array('c.city'=>'d.district_id', 'c.state' => 's.state_id');

        $result = $this->common_model->getData("client_master AS c","c.id, c.name, c.email, c.phone, CONCAT(c.address, ', ', d.district_name, ', ', s.state_name, ' - ', c.pincode) AS Address", $condition_arr, $search_arr, $col, $direction, $limit, $offset, $join_table, $join_condition);


        $response = array(
            'data' => $result,
            'total_records' => $total_records
        );
        echo json_encode($response);
    }
    
// state data
    public function fetchState() {
        $result = $this->common_model->getData('ms_state_master','state_id, state_name');
        echo json_encode($result);
    }
// city data
    public function fetchCity() {
        $id = empty($_POST['id']) ? '' : $_POST['id'];
        $condition_arr = array('state_id'=>$id);
        $result = $this->common_model->getData('ms_district_master', 'district_id, district_name', $condition_arr);
        echo json_encode($result);
    }
}