<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginPage extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('login');
    }

    public function verify_data() {
        $this->form_validation->set_message('required','%s required!');
        $this->form_validation->set_message('valid_email', 'Invalid %s!');
        $this->form_validation->set_message('check_captcha', 'Invalid captcha entered!');

        $this->form_validation->set_rules('loginEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('loginPswd', 'Password', 'required');
        $this->form_validation->set_rules('captcha', 'Captcha', 'required');

        if($this->form_validation->run() == false) {
            $response = array(
                'loginEmailErr' => $this->form_validation->error('loginEmail'),
                'loginPswdErr' => $this->form_validation->error('loginPswd'),
                'captchaErr' => $this->form_validation->error('captcha')
            );
            echo json_encode($response);
            exit;
        } else {
            $session_captcha = $this->session->userdata('captcha');
            $captcha = $this->input->post('captcha');
            if($session_captcha == $captcha) {
                $email = $this->input->post('loginEmail');
                $password = md5($this->input->post('loginPswd'));
                $condition = array('email'=>$email, 'password' => $password);
                $result = $this->common_model->getData('user_master', '*', $condition);
    
                if($result!=NULL) {
                    $keys = ['id', 'name', 'email'];
                    foreach($keys as $key) {
                        $this->session->set_userdata($key, $result[0][$key]);
                    }
                    $this->session->set_userdata('allowLogin', true);
                    $response = array('success' => true);
                    echo json_encode($response);
                    exit;
                } else {
                    $this->session->set_userdata('allowLogin', false);
                    $error = "Email and password do not match!";
                }
            } else {
                $error = "Invalid captcha entered!";
            }
            $response = array(
                'error'=> $error,
                'loginEmailErr' =>  '',
                'loginPswdErr' => '',
                'captchaErr' => ''
            );
        
            echo json_encode($response);
            exit;
        }
    }

        public function captcha() {
            $this->load->helper('captcha');
            $vals = array(
                'word_length'   => 6,
                'img_path'      => './captcha/',
                'img_url'       => base_url('captcha') . '/',
                'img_width'     => 120,
                'img_height'    => 40,
                'expiration'    => 7200,
                'font_size'     => 16,
                'pool'          => 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789',
                'colors'        => array(
                    'background' => array(248, 248, 248),
                    'border' => array(248, 248, 248),
                    'text' => array(0, 0, 0),
                    'grid' => array(190, 190, 190)
                ),
                'word_padding'  => 10
            );
            $cap = create_captcha($vals);
            $this->session->set_userdata('captcha', $cap['word']);
            $this->output
                ->set_content_type('image/png')
                ->set_output(file_get_contents($vals['img_path'] . $cap['filename']));
        }

    public function logout() {
        $this->load->view('logout');
    }
}