<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('data_validation');
    }

    public function index() {
        $this->load->view('invoice_master');
    }

// insert update invoice data 
    public function insertOrUpdate() {
        $fields = [
            'invoiceNo' => ['Invoice No', 'required|max_length[5]'],
            'invoiceDate' => ['Invoice Date', 'required'],   
            'cName' => ['Client Name', 'required'],
            'itemName[]' => ['Item Name', 'required'],
            'itemPrice[]' => ['Item Price', 'required|greater_than[0]'],
            'itemQty[]' => ['Item Quantity', 'required|max_length[2]|greater_than[0]'],
            'Amt[]' => ['Item total amount', 'required'],
            'totalAmt' => ['Total Amount', 'required|greater_than[0]']
        ];
        
        $clientname = $this->input->post('cName');
        $clientId = $this->input->post('clientId');
        $condition_arr = array('id'=> $clientId, 'name'=> $clientname); 
// check correct client name
        $result = $this->common_model->getData('client_master', 'name', $condition_arr);
        if($result==array()) {
            echo json_encode(array('success'=> false, 'error'=> 'Enter Correct Client Name!'));
            exit;
        }
 
        $result = $this->data_validation->validate($fields, 'invoice_master');
        if(!$result['success']) {
            echo json_encode($result);
            exit;
        }


        $post = $this->input->post();

        for($i = 0; $i < count($post['itemName']); $i++) {
            if($post['itemName'][$i]=='') {
                echo json_encode(array('error'=> 'Item name required!'));
                exit;
            } else if($post['itemId'][$i]=='') {
                echo json_encode(array('error' => 'Item not exists!'));
                exit;
            } else if($post['itemPrice'][$i] <= 0) {
                echo json_encode(array('error' => 'Please fill item price!'));
                exit;
            } else if($post['itemQty'][$i] <=0) {
                echo json_encode(array('error'=> 'Enter item quantity!'));
                exit;
            } else if($post['Amt'][$i]<=0) {
                echo json_encode(array('error'=> 'Plese fill the amount!'));
                exit;
            }
            // check item name if exists
            $condition_arr = array('id' => $post['itemId'][$i], 'name' => $post['itemName'][$i]);
            $chkItmName = $this->common_model->getData('item_master', 'name', $condition_arr);

            if($chkItmName==array()) {
                echo json_encode(array('error'=> 'item not exists!'));
                exit;
            }
        }

        $invoiceId = $this->input->post('invoiceId');
        $invoiceNo = $this->input->post('invoiceNo');
     
        $condition_arr = array('invoiceNo'=> $invoiceNo);
        $result = $this->data_validation->check_unique('invoice_master', $condition_arr, $invoiceId, 'invoiceId');
        if(!$result['success']) {
            echo json_encode(array('error'=> 'Invoice number already exists!'));
            exit;
        }

        $Rinvoiceid = $this->invoiceData();
        if($Rinvoiceid!=0) {
            $this->itemData($Rinvoiceid);
        }
        if($invoiceId) {
            echo json_encode(array('success' => true, 'update' => true));
        } else {    
            echo json_encode(array('success' => true, 'update' => false));
        }
    }
// save invoice master data
    private function invoiceData() {  
        $keys = ['invoiceId', 'invoiceNo', 'invoiceDate', 'clientId', 'totalAmt'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }
        $value_arr = array('invoiceNo' => $invoiceNo, 'invoiceDate' => $invoiceDate, 'clientId' => $clientId, 'grandTotal' => $totalAmt);
        if(empty($invoiceId)) {
            $result = $this->common_model->insertData('invoice_master', $value_arr, true);
            if($result['insertId']) {
                return $result['insertId'];
            } else {
                return 0;    
            }
        } else {
            $statement_arr = array('invoiceNo'=> $invoiceNo, 'invoiceDate'=> $invoiceDate, 'clientId'=> $clientId, 'grandTotal' => $totalAmt);
            $condition_arr = array('invoiceId' => $invoiceId);
            $result = $this->common_model->updateData('invoice_master', $statement_arr, $condition_arr);
            if($result['update']) {
                return $invoiceId;
            } else {
                return 0;    
            }
        }     
    }
// insert item data 
    private function itemData($invoiceid) {
        $id = $this->input->post('Id');
        $keys = ['itemId', 'itemName', 'itemPrice', 'itemQty', 'Amt'];
        foreach($keys as $key){
            $$key[] = $this->input->post($key);
        }

        if($id!='') {
            $result = $this->deleteItem($invoiceid);
        }
        for($i=0; $i<count($itemName[0]); $i++) {
            $value_arr = array('itemName' => $itemName[0][$i], 'itemPrice' => $itemPrice[0][$i], 'qty' => $itemQty[0][$i], 'invoiceId' => $invoiceid, 'itemId' => $itemId[0][$i], 'total' => $Amt[0][$i]);
            $result = $this->common_model->insertData('invoice_item', $value_arr);
        }      
    }

// fetch invoice table data
    public function fetchData() {
        $keys = ['col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }

        $result = $this->common_model->getData('invoice_master', 'COUNT(*) AS totals');
        $total_records = $result ? $result[0]['totals'] : 0;

        $join_table = ['client_master AS c'];
        $join_condition = array('c.id'=>'inv.clientId');

        $result = $this->common_model->getData("invoice_master AS inv", "inv.invoiceId, inv.invoiceNo, inv.invoiceDate, c.name, c.email, c.phone, inv.grandTotal", '', '', $col, $direction, $limit, $offset, $join_table, $join_condition);
        $response = array(
            'data' => $result,
            'total_records' => $total_records
        );
        echo json_encode($response);
    }

//search invoice data
    public function searchInvoice() {
        $keys = ['finvoiceNo', 'finvoiceDate', 'fclientName', 'fclientEmail', 'fclientPhone', 'col', 'direction', 'limit', 'offset'];
        foreach($keys as $key) {
            $$key = $this->input->post($key);
        }
        
        $condition_arr = array();
        if($finvoiceNo) {$condition_arr['invoiceNo'] = $finvoiceNo;}
        if($finvoiceDate) {$condition_arr['invoiceDate'] = $finvoiceDate;}
        if($fclientEmail) {$condition_arr['email'] = $fclientEmail;}
        if($fclientPhone) {$condition_arr['phone'] = $fclientPhone;}

        $like_arr = array();
        if($fclientName) {$like_arr['name'] = $fclientName;}

        $join_table = ['client_master AS c'];
        $join_condition = array('c.id'=>'inv.clientId');


        $result = $this->common_model->getData('invoice_master AS inv', 'COUNT(*) AS totals', $condition_arr, $like_arr, '', '', '', '', $join_table, $join_condition);
        $total_records = $result ? $result[0]['totals'] : 0;

        $result = $this->common_model->getData('invoice_master AS inv', "inv.invoiceId, inv.invoiceNo, inv.invoiceDate, c.name, c.email, c.phone, inv.grandTotal", $condition_arr, $like_arr, $col, $direction, $limit, $offset, $join_table, $join_condition);
        $response = array(
            'data' => $result,
            'total_records' => $total_records
        );
        echo json_encode($response);

    }

// delete invoice
    public function deleteData() {
        $invoiceId = $this->input->post('id');
        $condition_arr = array('invoiceId' => $invoiceId);
        $itemResult = $this->common_model->deleteData('invoice_item', $condition_arr);
        $response = array();
        if($itemResult['success']) {
            $condition_arr = array('invoiceId'=> $invoiceId);
            $invoiceResult = $this->common_model->deleteData('invoice_master', $condition_arr);
            $response = $invoiceResult;
        }
        echo json_encode($response);
    }

// fetch data for update invoice
    public function getEntry() {
        $invoiceId = $this->input->post('id');
        $condition_arr = array('invoiceId'=> $invoiceId);
        $invoiceResult = $this->common_model->getData('invoice_master', '*', $condition_arr);

        $response = array();
        if($invoiceResult) {
            if($invoiceResult[0]['clientId']) {
                $clientId = $invoiceResult[0]['clientId'];

                $response = json_decode(($this->ClientAutofill($clientId, true)), true);
                $response = array_merge($invoiceResult[0], $response);
            }
            $condition_arr = array('invoiceId'=> $invoiceId);
            $itemResult = $this->common_model->getData('invoice_item', '*', $condition_arr);

            $response = array('invoiceData' => $response, 'itemData' => $itemResult);
        }
        echo json_encode($response);
    }

//load invoice number
    public function autoInvoiceNo() {
        $result = $this->common_model->getData('invoice_master', 'MAX(invoiceNo) AS invoiceNo');
        echo json_encode($result[0]);
    }

//autoload client name
    public function clientName() {
        $this->input->post('clientname');
        $namelike = $this->input->post('clientname');
        $like_arr = array();
        if($namelike) { $like_arr['name'] = $namelike;}
        $result = $this->common_model->getData('client_master', 'id, name', '', $like_arr);

        $response = array();
        foreach($result as $row) {
            $response[] = array('id'=>$row['id'], 'value' => $row['name'], 'label' => $row['name']);
        }        
        echo json_encode($response);
    }
//autofill client details
    public function ClientAutofill($clientId='', $temp=false) {
        $id = empty($this->input->post('cid')) ? $clientId : $this->input->post('cid');
        $join_table = ['ms_district_master AS d', 'ms_state_master AS s'];
        $join_condition = array('c.city'=>'d.district_id', 'c.state' => 's.state_id');
        
        $condition_arr = array('c.id'=> $id);
        $result = $this->common_model->getData("client_master AS c","c.id, c.name, c.email, c.phone, CONCAT(c.address, ', ', d.district_name, ', ', s.state_name, ' - ', c.pincode) AS Address", $condition_arr, "", "", "", "", "", $join_table, $join_condition);
        // print_r($result[0]);
        if($temp==true) {
            return json_encode($result[0]);
        }
        echo json_encode($result[0]);
    }

// load item name
    public function itemName() {
        $namelike = $this->input->post('itemname');
        $like_arr = array();
        if($namelike) { $like_arr['name'] = $namelike;}
        $result = $this->common_model->getData('item_master', 'id, name, price', '', $like_arr);
        $response = array();
        foreach($result as $row) {
            $response[] = array('id'=>$row['id'], 'value'=>$row['name'], 'label'=>$row['name'], 'price'=>$row['price']);
        }
        echo json_encode($response);
    }

// delete item data
    public function deleteItem($invoiceId) {
        $condition_arr = array('invoiceId'=>$invoiceId);
        $result = $this->common_model->deleteData('invoice_item', $condition_arr); 
        return $result;
    }

//pdf create function
    public function pdfCreate() {
        
        $invoiceId = $this->input->post('pdfId');
    
        $result = $this->pdfcommon($invoiceId);
        $invoiceData = $result['invoiceData'];
        $itemData = $result['itemData'];
        $pdfview = $this->load->view('pdf', $result, true);
        
        // $path = FCPATH.'vendor/pdfDownload.php';
        // require $path;

        $filename = "pdf/invoice".$invoiceData[0]['invoiceId'].".pdf";
        $filePath = FCPATH.$filename;
        $fileUrl = base_url($filename);

        $this->load->library('Pdfgenerate');
        $this->pdfgenerate->pdfsave($filePath, array($pdfview), 4, 'F');
        echo json_encode(array('result' => $fileUrl));
        // $file = "invoice".$invoiceData[0]['invoiceId'].".pdf";
        // $response = array('filepath' => $filename, 'filename' => $file);
    }

// fetch data to display on pdf 
    private function pdfcommon($invoiceId) {
        $condition_arr = array('invoiceId'=>  $invoiceId);
        $join_table = ['client_master AS c', 'ms_district_master AS d', 'ms_state_master AS s'];
        $join_condition = array('c.id'=>'inv.clientId', 'c.city'=>'d.district_id', 'c.state' => 's.state_id');

        $invoiceData = $this->common_model->getData("invoice_master AS inv", "inv.invoiceId, inv.invoiceNo, inv.invoiceDate, c.name, c.email, c.phone, CONCAT(c.address, ', ', d.district_name, ', ', s.state_name, ' - ', c.pincode) AS Address, inv.grandTotal", $condition_arr, '', '', '', '', '', $join_table, $join_condition);

        $itemData = $this->common_model->getData("invoice_item", "*", $condition_arr);

        $response = array(
            'invoiceData' => $invoiceData,
            'itemData' => $itemData
        );

        return $response;
    }

//autodata on mail modal
    public function mailEntry() {
        $invoiceId = $this->input->post('mailId');

        $condition_arr = array('invoiceId' => $invoiceId);
        $join_table = ['client_master AS c'];
        $join_condition = array('c.id'=>'inv.clientId');

        $result = $this->common_model->getData("invoice_master AS inv", "inv.invoiceId, inv.invoiceNo, c.name, c.email", $condition_arr, '', '', '', '', '', $join_table, $join_condition);
        echo json_encode($result[0]);
    }

//sending mail
    public function sendMail() {
        $invoiceId = $this->input->post('invId');
        $email = $this->input->post('mailId');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        if(!empty($email && $subject && $message)) {
            $fileResult = $this->pdfcommon($invoiceId);
            $invoiceData = $fileResult['invoiceData'];
            $itemData = $fileResult['itemData'];

            $pdfview = $this->load->view('pdf', $fileResult, true);
            $filePath = "pdf/invoice".$invoiceData[0]['invoiceId'].".pdf";
            $file = FCPATH.$filePath;
            $fileUrl = base_url($filePath);
            $filename = "invoice".$invoiceData[0]['invoiceId'].".pdf";
            $this->load->library('Pdfgenerate');
            $this->pdfgenerate->pdfsave($filePath, array($pdfview), 4, 'F');

            $this->load->library('Mailer');
            $result = $this->mailer->sendmail($email, $subject, $message, $filePath, $filename);
            
            echo json_encode($result);
        }
    }

}