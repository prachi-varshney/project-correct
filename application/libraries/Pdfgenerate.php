<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH. 'vendor\autoload.php';

class Pdfgenerate {
    public function __construct() {
        $this->CI = &get_instance();
    }

    function pdfsave($invoice, $html, $margin=0, $mode='F') {

        $mpdf = new \Mpdf\Mpdf();
        foreach($html as $key => $content) {
            if($key>0) {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($content);
        }
        return $mpdf->output($invoice, $mode);
    }    

}