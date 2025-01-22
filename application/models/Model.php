<?php

class Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getData($table, $field='*', $condition=array(), $like=array(), $order_by_field='', $order_by_type='', $limit='', $offset='', $join=array(), $join_condition=array(), $NOT=array(), $return_query = false) {
        $this->db->select($field)
                 ->from($table);
        
        if($join!='') {
            $i = 0;
            foreach($join_condition as $key => $value) {
                // $sql .= " JOIN $join[$i] ON $key=$value";
                $this->db->join($join[$i], "$key=$value");
                $i++;
            }
        }

        if(!empty($condition)) {
            $this->db->where($condition);
        }
        
        if(!empty($NOT)) {
            foreach($NOT as $key => $value) {
                $this->db->where("$key !=", $value);
            }
        }

        if(!empty($like)){
            $this->db->like($like);
        }
        
        if($order_by_field!='' && $order_by_type!='') {
            $this->db->order_by($order_by_field, $order_by_type);
        }

        if($limit!='' && $offset!='') {
            $this->db->limit($limit, $offset);
        }

        if ($return_query) {
        $sql = $this->db->get_compiled_select();
            return $sql;
        }

        $query = $this->db->get();
        if($query->num_rows()>0) {
            return $query->result_array();
        } else {
            return array();
        }

    }

    public function insertData($table, $data) {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function updateData($table, $data, $condition) {
        $this->db->where($condition);
        $result = $this->db->update($table, $data);
     
        $response = array(
            'success' => $result,
            'update' => $result
        );

        return $response;
    }


    public function deleteData($table, $condition) {
        // $this->db->db_debug = true;

        $this->db->where($condition);
        $result = $this->db->delete($table);
    
        if(!$result) {
            $error = $this->db->error();
            return array(
                'success' => false,
                'error' => $error['message'],
                'error_code' => $error['code']
            );
        } else {
            if ($this->db->affected_rows() > 0) {
                return array('success' => true, 'affected_rows' => $this->db->affected_rows());
            } else {
                return array('success' => false, 'message' => 'No rows were deleted');
            }
        }
    }
}