<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Common extends REST_Controller {

	public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Type: application/json; charset=utf-8'); 
    }

   /*200 = OK
    201 = Bad Request (Required param is missing)
    202 = No Valid Auth key
    204 = No post data
    203 = Generic Error
    205 = Form Validation failed
    206 = Queury Failed
    207 = Already Logged-In Error
    208 = Curl Failed
    209 = Curl UNAUTHORIZED
    */ 
	public function index() {
        $response = array('status' => false, 'msg' => 'Oops! Please try again later.', 'code' => 200);
        echo json_encode($response);
    }
    public function register_data_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $phone_no = $this->input->post('phone_no');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($phone_no)){
                    $response['message'] = "Phone No is required";
                    $response['code'] = 201;
                }else{
                    $check_contact_no_count = $this->model->CountWhereRecord('tbl_users', array('contact_no'=>$phone_no,'login_status'=>1,'del_status'=>1));
                    $check_email_count = $this->model->CountWhereRecord('tbl_users', array('email'=>$email,'login_status'=>1,'del_status'=>1));
                    if($check_contact_no_count > 0){
                        $response['code'] = 201;
                        $response['status'] = false;
                        $response['message'] = 'Contact No is Already exist.';                     
                    }elseif($check_email_count > 0){
                        $response['code'] = 201;
                        $response['status'] = false;
                        $response['message'] = 'Email is Already exist.';                     
                    }else{
                        $user_type = $this->model->selectWhereData('tbl_user_type',array('user_type'=>"Superadmin"),array('id'));
                        $curl_data =  array(
                            'first_name' => $first_name,
                            'last_name' =>  $last_name,
                            'email' => $email,
                            'contact_no' => $phone_no,
                            'password' => dec_enc('encrypt',$password),
                            'fk_user_type'=>$user_type['id']
                        );
                        $inserted_id = $this->model->insertData('tbl_users',$curl_data);
                       
                        $response['code'] = REST_Controller::HTTP_OK;
                        $response['status'] = true;
                        $response['message'] = 'Register Successfully';
                    }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function login_data_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
            $email = $this->input->post('email');           
            $password = $this->input->post('password');
            if (empty($email)) {
                $response['message'] = 'Email is required.';
                $response['code'] = 201;
            } else if (empty($password)) {
                $response['message'] = 'Password is required.';
                $response['code'] = 201;
            } else {
                $encryptedpassword = dec_enc('encrypt',$password);
                $check_email_count = $this->model->CountWhereRecord('tbl_users',array('email'=>$email));
                if($check_email_count > 0) {       
                    $login_credentials_data = array(
                      "email" => $email,
                      "password" => $encryptedpassword
                    );
                    $login_info = $this->model->selectWhereData('tbl_users',$login_credentials_data,'*');
                    if(!empty($login_info)){
                            $response['code'] = REST_Controller::HTTP_OK;;
                            $response['status'] = true;
                            $response['message'] = 'success';
                            $response['data'] = $login_info;
                    } else {
                        $response['code'] = 201;
                        $response['status'] = "wrong_password";
                        $response['message'] = 'Incorrect Password';
                    }      
                }  else {
                    $response['code'] = 201;
                    $response['message'] = 'Incorrect Username';
                    $response['status'] = "wrong_username";
                }          
            } 
        echo json_encode($response);
    } 
}