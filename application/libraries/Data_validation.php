<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_validation {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        // $this->CI->load->library('form_validation');
        // $this->CI->load->model('Common_model');
    }

    public function validate($fields, $table) {
        $errors = [];

        foreach ($fields as $field => $rules) {
            $this->CI->form_validation->set_rules($field, $rules[0], $rules[1]);
            
            if ($this->CI->form_validation->run() == FALSE) {
                $errors[$field] = $this->CI->form_validation->error($field);
            }
        }

        if (!empty($errors)) {
            return array('success' => false, 'error' => $errors);
        }

        return array('success' => true);
    }

    public function check_unique($table, $condition_arr, $id = null, $Idname = null) {
        $NOT = array();
        if ($id) {
            $NOT[$Idname] = $id;
        }
        $result = $this->CI->common_model->getData($table, 'COUNT(*) AS totals', $condition_arr, '', '', '', '', '', '', '', $NOT);
        if($result[0]['totals'] == 0) {
            return array('success' => true);
        } else {
            return array('success' => false);
        }
    }
}