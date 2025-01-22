<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->database();
        // $this->load->library('session');
        // $this->load->model('common_model');
        // $this->load->helper('url');
    }
    public function index() {
        $data['users'] = $this->common_model->getData('user_master', 'COUNT(*) AS totals')[0]['totals'];
        $data['clients'] = $this->common_model->getData('client_master', 'COUNT(*) AS totals')[0]['totals'];
        $data['items'] = $this->common_model->getData('item_master', 'COUNT(*) AS totals')[0]['totals'];
        $data['invoices'] = $this->common_model->getData('invoice_master', 'COUNT(*) AS totals')[0]['totals'];
        $this->load->view('Home', $data);
    }

}