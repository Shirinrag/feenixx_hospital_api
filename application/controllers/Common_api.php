<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Common_api extends REST_Controller {

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
                // echo '<pre>'; print_r($encryptedpassword); exit;
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
                        $response['error_status'] = "wrong_password";
                        $response['message'] = 'Incorrect Password';
                    }      
                }  else {
                    $response['code'] = 201;
                    $response['message'] = 'Incorrect Username';
                    $response['error_status'] = "wrong_username";
                }          
            } 
        echo json_encode($response);
    } 
    public function get_all_common_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $gender = $this->model->selectWhereData('tbl_gender',array(),array('id','gender'),false);
            $marital_status = $this->model->selectWhereData('tbl_marital_status',array('status'=>1),array('id','marital_status'),false);
            $state_data = $this->model->selectWhereData('tbl_states',array(),array('id','name'),false);
            $designation_data = $this->model->selectWhereData('tbl_designation',array(),array('id','designation_name'),false);
            $blood_group_data = $this->model->selectWhereData('tbl_blood_group',array(),array('id','blood_group'),false);
            $user_type = $this->model->selectWhereData('tbl_user_type',array('del_status'=>1),array('id','user_type'),false);
            $patient_id = random_strings();
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['gender_data'] = $gender;
            $response['marital_status_data'] = $marital_status;
            $response['state_data'] = $state_data;
            $response['designation_data'] = $designation_data;
            $response['blood_group_data'] = $blood_group_data;
            $response['patient_id'] = $patient_id;
            $response['user_type'] = $user_type;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_city_data_on_state_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $state_id = $this->input->post('state');
            $city_data = $this->model->selectWhereData('tbl_cities',array('state_id'=>$state_id),array('id','city'),false);
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['city_data'] = $city_data;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_appointment_data_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $patient_data = $this->model->selectWhereData('tbl_patients',array('del_status'=>1,'status'=>1),array('id','patient_id','contact_no'),false);
            $diseases_data = $this->model->selectWhereData('tbl_diseases',array('status'=>1,'del_status'=>1),array('id','diseases_name'),false,array('id','DESC'));            
            $doctor_data = $this->model->selectWhereData('tbl_doctor',array('status'=>1,'del_status'=>1),array('id','first_name','last_name'),false,array('id','DESC'));            
            $appointment_type = $this->model->selectWhereData('tbl_appointment_type',array('status'=>1),array('id','type'),false,array('id','DESC'));              
            $location_data = $this->model->selectWhereData('tbl_visit_location',array('del_status'=>1),array('id','place_name'),false,array('id','DESC'));              
            $charges_data = $this->model->selectWhereData('tbl_charges_type',array('del_status'=>1,'status'=>1),array('id','charges_name'),false,array('id','DESC'));              
            $payment_type = $this->model->selectWhereData('tbl_payment_type',array('del_status'=>1,'status'=>1),array('id','payment_type'),false,array('id','DESC'));              
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['patient_data'] = $patient_data;
            $response['diseases_data'] = $diseases_data;
            $response['appointment_type'] = $appointment_type;
            $response['doctor_data'] = $doctor_data;
            $response['location_data'] = $location_data;
            $response['charges_data'] = $charges_data;
            $response['payment_type'] = $payment_type;

        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_user_type_on_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $id = $this->input->post('id');
            if(empty($id)){
                $response['code'] = 201;
                $response['message'] = "Id is required";
            }else{
               $user_type = $this->model->selectWhereData('tbl_user_type',array('id'=>$id),array('user_type'));                  
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['user_type'] = $user_type['user_type'];
            }
            
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_sub_type_data_on_appoitment_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $id = $this->input->post('id');
            if(empty($id)){
                $response['code'] = 201;
                $response['message'] = "Id is required";
            }else{
               $appointment_sub_type = $this->model->selectWhereData('tbl_appointment_sub_type',array('fk_appointment_type_id'=>$id),array('id','sub_type'),false);          
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['appointment_sub_type'] = $appointment_sub_type;
            }
            
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function get_doctor_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $id = $this->input->post('id');
            if(empty($id)){
                $response['code']=201;
                $response['message']="Id is required";
            }else{
                $doctor_data = $this->model->selectWhereData('tbl_doctor',array('status'=>1,'del_status'=>1,'id'=>$id),array('fk_gender_id'));            
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;  
                if(!empty($doctor_data)){
                    $response['doctor_data'] = $doctor_data;
                }else{
                    $response['doctor_data'] = [];
                }
            }           
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
}