<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Superadmin_api extends REST_Controller {

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
    //============================= Add Doctor==================================
    public function add_doctor_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $phone_no = $this->input->post('phone_no');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $specialization = $this->input->post('specialization');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $profile_image = $this->input->post('image');
                $added_by = $this->input->post('added_by');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($phone_no)){
                    $response['message'] = "Phone No is required";
                    $response['code'] = 201;
                }else if(empty($email)){
                    $response['message'] = "Email is required";
                    $response['code'] = 201;

                }else if(empty($specialization)){
                    $response['message'] = "Specialization is required";
                    $response['code'] = 201;
                }else if(empty($dob)){
                    $response['message'] = "DOB is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{
                    $is_file = true;
                    if (!empty($_FILES['image']['name'])) {
                        $image = trim($_FILES['image']['name']);
                        $image = preg_replace('/\s/', '_', $image);
                        $cat_image = mt_rand(100000, 999999) . '_' . $image;
                        $config['upload_path'] = './uploads/';
                        $config['file_name'] = $cat_image;
                        $config['overwrite'] = TRUE;
                        $config["allowed_types"] = 'gif|jpg|jpeg|png|bmp';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            $is_file = false;
                            $errors = $this->upload->display_errors();
                            $response['code'] = 201;
                            $response['message'] = $errors;
                        } else {
                            $profile_image = 'uploads/' . $cat_image;
                        }
                    }
                    if ($is_file) {
                        $check_contact_no_count = $this->model->CountWhereRecord('tbl_doctor', array('contact_no'=>$phone_no,'status'=>1,'del_status'=>1));
                        $check_contact_no_count_1 = $this->model->CountWhereRecord('tbl_users', array('contact_no'=>$phone_no,'login_status'=>1,'del_status'=>1));
                        $check_email_count = $this->model->CountWhereRecord('tbl_doctor', array('email'=>$email,'status'=>1,'del_status'=>1));
                        $check_email_count_1 = $this->model->CountWhereRecord('tbl_users', array('email'=>$email,'login_status'=>1,'del_status'=>1));
                        if($check_contact_no_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }else if($check_contact_no_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }elseif($check_email_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }elseif($check_email_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }else{
                            $user_type = $this->model->selectWhereData('tbl_user_type',array('user_type'=>"Doctor"),array('id'));
                            $curl_data =  array(
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'fk_designation_id'=>$specialization,
                                'address1'=>$address1,
                                'address2'=>$address2,
                                'state'=>$state,
                                'city'=>$city,
                                'pincode'=>$pincode,
                                'dob'=>$dob,
                                'image'=>$profile_image,
                                'fk_gender_id'=>$gender
                            );
                            $inserted_id = $this->model->insertData('tbl_doctor',$curl_data);

                            $insert_data=array(
                                'fk_id'=>$inserted_id,
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'password' => dec_enc('encrypt',$password),
                                'fk_user_type'=>$user_type['id'],
                                'added_by'=>$added_by
                            );
                            $this->model->insertData('tbl_users',$insert_data);
                            $this->load->model('email_model');
                            $name = $first_name. " ".$last_name;
                            $this->email_model->register_email($email,$email,$password,$name);
                           
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Doctor Details Added Successfully';
                        }
                    }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function display_all_doctor_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $this->load->model('doctor_model');
                $doctor_data = $this->doctor_model->get_datatables();
                $count = $this->doctor_model->count_all();
                $count_filtered = $this->doctor_model->count_filtered();             

                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['doctor_data'] = $doctor_data;
                $response['count'] = $count;
                $response['count_filtered'] = $count_filtered;
        } else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_all_doctor_on_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $doctor_details = $this->model->selectWhereData('tbl_doctor',array('id'=>$id),array('*'));
                    $city_data = $this->model->selectWhereData('tbl_cities',array('state_id'=>$doctor_details['state']),array('id','city'),false);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['doctor_details_data'] = $doctor_details;
                    $response['city_data'] = $city_data;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_doctor_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $specialization = $this->input->post('specialization');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $profile_image = $this->input->post('image');
                $id = $this->input->post('id');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($id)){
                    $response['message'] = " Id is required";
                    $response['code'] = 201;
                }else if(empty($specialization)){
                    $response['message'] = " Specialization is required";
                    $response['code'] = 201;
                }else if(empty($dob)){
                    $response['message'] = "DOB is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else if(empty($gender)){
                    $response['message'] = "Gender is required";
                    $response['code'] = 201;
                }else{
                    $is_file = true;
                    $profile_image1 ="";
                    if (!empty($_FILES['image']['name'])) {
                        $image = trim($_FILES['image']['name']);
                        $image = preg_replace('/\s/', '_', $image);
                        $cat_image = mt_rand(100000, 999999) . '_' . $image;
                        $config['upload_path'] = './uploads/';
                        $config['file_name'] = $cat_image;
                        $config['overwrite'] = TRUE;
                        $config["allowed_types"] = 'gif|jpg|jpeg|png|bmp';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            $is_file = false;
                            $errors = $this->upload->display_errors();
                            $response['code'] = 201;
                            $response['message'] = $errors;
                        } else {
                                $profile_image = 'uploads/' . $cat_image;
                        }
                    }
                    if ($is_file) {
                        $user_data = $this->model->selectWhereData('tbl_doctor',array('id'=>$id),array('image'));
                        if(empty($profile_image)){
                            $profile_image1 = $user_data['image'];
                        }else{
                            $profile_image1 = $profile_image;
                        }
                        $curl_data =  array(
                            'first_name' => $first_name,
                            'last_name' =>  $last_name,
                            'image' => $profile_image1,
                            'fk_designation_id'=>$specialization,
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'state'=>$state,
                            'city'=>$city,
                            'pincode'=>$pincode,
                            'dob'=>$dob,
                            'fk_gender_id'=>$gender,
                        );
                        $this->model->updateData('tbl_doctor',$curl_data,array('id'=>$id));

                        $update_data = array(
                            'first_name' => $first_name,
                            'last_name' =>  $last_name,
                        );
                        $this->model->updateData('tbl_users',$update_data,array('fk_id'=>$id,'fk_user_type'=>2));

                        $response['code'] = REST_Controller::HTTP_OK;
                        $response['status'] = true;
                        $response['message'] = 'Doctor Details Updated Successfully';
                    }

                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_doctor_status_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if($validate){
            $id = $this->input->post('id');
            $status=$this->input->post('status');
            if (empty($id)) {
                $response['message'] = 'id is required';
                $response['code'] = 201;
            } else {
                $update_data = array(
                    'status'=>$status,
                );
                $this->model->updateData('tbl_doctor',$update_data, array('id'=>$id));
                 // $this->model->updateData('tbl_users',$update_data,array('fk_id'=>$id,'fk_user_type'=>2));
                $response['message'] = 'success';
                $response['code'] = 200;
                $response['status'] = true;
            }
        } else {
            $response['message'] = 'Invalid Request';
            $response['code'] = 204;
        }
        echo json_encode($response);
    }
    public function delete_doctor_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_doctor',$curl_data,array('id'=>$id));
                    $this->model->updateData('tbl_users',$curl_data,array('fk_id'=>$id,'fk_user_type'=>2));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Doctor Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    // =============================== Add Patient =========================
    public function add_patient_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $patient_id = $this->input->post('patient_id');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $phone_no = $this->input->post('phone_no');
                $email = $this->input->post('email');
                $marital_status = $this->input->post('marital_status');
                $blood_group = $this->input->post('blood_group');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $emergency_contact_name = $this->input->post('emergency_contact_name');
                $emergency_contact_phone = $this->input->post('emergency_contact_phone');
                $insurance_document = $this->input->post('insurance_document');
                $added_by = $this->input->post('added_by');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($phone_no)){
                    $response['message'] = "Phone No is required";
                    $response['code'] = 201;
                }else if(empty($marital_status)){
                    $response['message'] = "Marital Status is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{                    
                        $check_contact_no_count = $this->model->CountWhereRecord('tbl_patients', array('contact_no'=>$phone_no,'status'=>1,'del_status'=>1));
                        $check_contact_no_count_1 = $this->model->CountWhereRecord('tbl_users', array('contact_no'=>$phone_no,'login_status'=>1,'del_status'=>1));
                        $check_email_count = $this->model->CountWhereRecord('tbl_patients', array('email'=>$email,'status'=>1,'del_status'=>1));
                        $check_email_count_1 = $this->model->CountWhereRecord('tbl_users', array('email'=>$email,'login_status'=>1,'del_status'=>1));
                        if($check_contact_no_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }elseif($check_contact_no_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }elseif($check_email_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }elseif($check_email_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }else{
                            $user_type = $this->model->selectWhereData('tbl_user_type',array('user_type'=>"Patient"),array('id'));
                            $curl_data =  array(
                                'patient_id' => $patient_id,
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'fk_marital_status_id'=>$marital_status,
                                'address1'=>$address1,
                                'address2'=>$address2,
                                'state'=>$state,
                                'city'=>$city,
                                'pincode'=>$pincode,
                                'dob'=>$dob,
                                'fk_gender_id'=>$gender,
                                'fk_blood_group_id'=>$blood_group,
                                'emergency_contact_phone'=>$emergency_contact_phone,
                                'emergency_contact_name'=>$emergency_contact_name,
                                'insurance_document'=>$insurance_document
                            );
                            $inserted_id = $this->model->insertData('tbl_patients',$curl_data);
                            $password = "Password1";
                            $insert_data=array(
                                'fk_id'=>$inserted_id,
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'password' => dec_enc('encrypt',$password),
                                'fk_user_type'=>$user_type['id'],
                                'added_by'=>$added_by
                            );
                            $this->model->insertData('tbl_users',$insert_data);
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Patient Details Added Successfully';
                        }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function display_all_patient_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $this->load->model('patient_model');
                $patient_data = $this->patient_model->get_datatables();
                $count = $this->patient_model->count_all();
                $count_filtered = $this->patient_model->count_filtered();            

                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['patient_data'] = $patient_data;
                $response['count'] = $count;
                $response['count_filtered'] = $count_filtered;
        } else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_all_patient_on_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $patient_details = $this->model->selectWhereData('tbl_patients',array('id'=>$id),array('*'));
                    $city_data = $this->model->selectWhereData('tbl_cities',array('state_id'=>$patient_details['state']),array('id','city'),false);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['patient_details_data'] = $patient_details;
                    $response['city_data'] = $city_data;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_patient_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $marital_status = $this->input->post('marital_status');
                $blood_group = $this->input->post('blood_group');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $emergency_contact_name = $this->input->post('emergency_contact_name');
                $emergency_contact_phone = $this->input->post('emergency_contact_phone');
                $insurance_document = $this->input->post('insurance_document');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($marital_status)){
                    $response['message'] = "Marital Status is required";
                    $response['code'] = 201;
                }else if(empty($dob)){
                    $response['message'] = "DOB is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{         
                $insurance_document_1 = $this->model->selectWhereData('tbl_patients',array('id'=>$id),array('insurance_document'));
                $insurance_document_2 ='';
                if(empty($insurance_document))   {
                    $insurance_document_2 = $insurance_document_1['insurance_document'];
                }else{
                    $insurance_document_2 = $insurance_document;
                }
                            $curl_data =  array(
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'fk_marital_status_id'=>$marital_status,
                                'address1'=>$address1,
                                'address2'=>$address2,
                                'state'=>$state,
                                'city'=>$city,
                                'pincode'=>$pincode,
                                'dob'=>$dob,
                                'fk_gender_id'=>$gender,
                                'fk_blood_group_id'=>$blood_group,
                                'emergency_contact_phone'=>$emergency_contact_phone,
                                'emergency_contact_name'=>$emergency_contact_name,
                                'insurance_document'=>$insurance_document_2,
                            );
                            $this->model->updateData('tbl_patients',$curl_data,array('id'=>$id));
                            $password = "Password1";
                            $update_data=array(
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                            );
                            $this->model->updateData('tbl_users',$update_data,array('fk_id'=>$id,'fk_user_type'=>4));
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Patient Details Updated Successfully';
                        }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function delete_patient_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_patients',$curl_data,array('id'=>$id));
                    $this->model->updateData('tbl_users',$curl_data,array('fk_id'=>$id,'fk_user_type'=>4));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Patient Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    // =============================== Add Diseases==========================
    public function add_diseases_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $diseases = $this->input->post('diseases');
                if(empty($diseases)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else{
                        $check_diseases_count = $this->model->CountWhereRecord('tbl_diseases', array('diseases_name'=>$diseases,'del_status'=>1));
                        if($check_diseases_count > 0){
                             $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Dieases is Already exist.';
                        }else{                            
                            $curl_data =  array(
                                'diseases_name' => $diseases,
                            );
                            $inserted_id = $this->model->insertData('tbl_diseases',$curl_data);                       
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Dieases Added Successfully';
                        }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function display_all_diesases_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                 $this->load->model('superadmin_model');
                $diseases_data = $this->superadmin_model->display_all_diesases_details();
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['diseases_data'] = $diseases_data;
        } else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_diseases_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $diseases = $this->input->post('diseases');
                $id = $this->input->post('id');
                if(empty($diseases)){
                    $response['message'] = "Diseases is required";
                    $response['code'] = 201;
                }else{
                    $curl_data =  array(
                        'diseases_name' => $diseases,                       
                    );
                    $this->model->updateData('tbl_diseases',$curl_data,array('id'=>$id));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Diseases Updated Successfully';

                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_diseases_status_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if($validate){
            $id = $this->input->post('id');
            $status=$this->input->post('status');
            if (empty($id)) {
                $response['message'] = 'id is required';
                $response['code'] = 201;
            } else {
                $update_data = array(
                    'status'=>$status,
                );
                $this->model->updateData('tbl_diseases',$update_data, array('id'=>$id));
                $response['message'] = 'Status Changed Successfully';
                $response['code'] = 200;
                $response['status'] = true;
            }
        } else {
            $response['message'] = 'Invalid Request';
            $response['code'] = 204;
        }
        echo json_encode($response);
    }
    public function delete_diseases_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_diseases',$curl_data,array('id'=>$id));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Diseases Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function superadmin_dashboard_count_data_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $doctor_count = $this->model->CountWhereInRecord('tbl_doctor',array('del_status'=>1));
            $active_doctor_count = $this->model->CountWhereInRecord('tbl_doctor',array('del_status'=>1,'status'=>1));
            $inactive_doctor_count = $this->model->CountWhereInRecord('tbl_doctor',array('del_status'=>1,'status'=>0));
            $male_doctor_count = $this->model->CountWhereInRecord('tbl_doctor',array('del_status'=>1,'fk_gender_id'=>1));
            $female_doctor_count = $this->model->CountWhereInRecord('tbl_doctor',array('del_status'=>1,'fk_gender_id'=>2));
            $patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1));
            $male_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>1));
            $female_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>2));
            $transgender_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>3));
            $appointment_count = $this->model->countrecord('tbl_appointment');
            $diseases_count = $this->model->CountWhereInRecord('tbl_diseases',array('del_status'=>1));
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['doctor_count'] = $doctor_count;
            $response['active_doctor_count'] = $active_doctor_count;
            $response['inactive_doctor_count'] = $inactive_doctor_count;
            $response['male_doctor_count'] = $male_doctor_count;
            $response['female_doctor_count'] = $female_doctor_count;
            $response['patient_count'] = $patient_count;
            $response['male_patient_count'] = $male_patient_count;
            $response['female_patient_count'] = $female_patient_count;
            $response['transgender_patient_count'] = $transgender_patient_count;
            $response['appointment_count'] = $appointment_count;
            $response['diseases_count'] = $diseases_count;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    // ====================================Staff ==============================
     // =============================== Add Patient =========================
    public function add_staff_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $user_type = $this->input->post('user_type');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $phone_no = $this->input->post('phone_no');
                $email = $this->input->post('email');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $pan_card = $this->input->post('pan_card');
                $aadhar_card = $this->input->post('aadhar_card');
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
                }else if(empty($email)){
                    $response['message'] = "Email is required";
                    $response['code'] = 201; 
                }else if(empty($dob)){
                    $response['message'] = "DOB is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{                    
                        $check_contact_no_count = $this->model->CountWhereRecord('tbl_staff', array('contact_no'=>$phone_no,'status'=>1,'del_status'=>1));
                        $check_contact_no_count_1 = $this->model->CountWhereRecord('tbl_users', array('contact_no'=>$phone_no,'login_status'=>1,'del_status'=>1));
                        $check_email_count = $this->model->CountWhereRecord('tbl_staff', array('email'=>$email,'status'=>1,'del_status'=>1));
                        $check_email_count_1 = $this->model->CountWhereRecord('tbl_users', array('email'=>$email,'login_status'=>1,'del_status'=>1));
                        if($check_contact_no_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }elseif($check_contact_no_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Contact No is Already exist.';
                            $response['error_status'] = 'contact_no';                     
                        }elseif($check_email_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }elseif($check_email_count_1 > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Email is Already exist.';
                            $response['error_status'] = 'email';                     
                        }else{
                            $curl_data =  array(
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'address1'=>$address1,
                                'address2'=>$address2,
                                'fk_state_id'=>$state,
                                'fk_city_id'=>$city,
                                'pincode'=>$pincode,
                                'dob'=>$dob,
                                'fk_gender_id'=>$gender,
                                'pan_card'=>$pan_card,
                                'aadhar_card'=>$aadhar_card,
                            );
                            $inserted_id = $this->model->insertData('tbl_staff',$curl_data);
                            $insert_data=array(
                                'fk_id'=>$inserted_id,
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'password' => dec_enc('encrypt',$password),
                                'fk_user_type'=>$user_type,
                            );
                            $this->model->insertData('tbl_users',$insert_data);
                            $this->load->model('email_model');
                            $name = $first_name. " ".$last_name;
                            $this->email_model->register_email($email,$email,$password,$name);
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Staff Details Added Successfully';
                        }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function display_all_staff_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $this->load->model('staff_model');
                $staff_data = $this->staff_model->get_datatables();
                $count = $this->staff_model->count_all();
                $count_filtered = $this->staff_model->count_filtered(); 
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['staff_data'] = $staff_data;
                $response['count'] = $count;
                $response['count_filtered'] = $count_filtered;
        } else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_all_staff_on_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $this->load->model('superadmin_model');
                    $staff_details = $this->superadmin_model->get_all_staff_on_id($id);
                    $city_data = $this->model->selectWhereData('tbl_cities',array('state_id'=>$staff_details['fk_state_id']),array('id','city'),false);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['staff_details_data'] = $staff_details;
                    $response['city_data'] = $city_data;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_staff_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $dob = $this->input->post('dob');
                $gender = $this->input->post('gender');              
                $pan_card = $this->input->post('pan_card');
                $aadhar_card = $this->input->post('aadhar_card');
                $user_type = $this->input->post('user_type');
                if(empty($first_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else if(empty($last_name)){
                    $response['message'] = "Last Name is required";
                    $response['code'] = 201;
                }else if(empty($dob)){
                    $response['message'] = "DOB is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{    
                $staff_detais = $this->model->selectWhereData('tbl_staff',array('id'=>$id),array('pan_card','aadhar_card'));
                $pan_card_1 ='';
                if(empty($pan_card))   {
                    $pan_card_1 = $staff_detais['pan_card'];
                }else{
                    $pan_card_1 = $pan_card;
                }    
                $aadhar_card_1 ='';
                if(empty($aadhar_card))   {
                    $aadhar_card_1 = $staff_detais['aadhar_card'];
                }else{
                    $aadhar_card_1 = $aadhar_card;
                }                
                    $curl_data =  array(
                        'first_name' => $first_name,
                        'last_name' =>  $last_name,
                        'address1'=>$address1,
                        'address2'=>$address2,
                        'fk_state_id'=>$state,
                        'fk_city_id'=>$city,
                        'pincode'=>$pincode,
                        'dob'=>$dob,
                        'fk_gender_id'=>$gender,
                        'pan_card'=>$pan_card_1,
                        'aadhar_card'=>$aadhar_card_1,
                    );
                    $this->model->updateData('tbl_staff',$curl_data,array('id'=>$id));
                    $update_data=array(
                        'first_name' => $first_name,
                        'last_name' =>  $last_name,
                    );
                    $this->model->updateData('tbl_users',$update_data,array('fk_id'=>$id,'fk_user_type'=>$user_type));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Staff Details Updated Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function delete_staff_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_staff',$curl_data,array('id'=>$id));
                    $this->model->updateData('tbl_users',$curl_data,array('fk_id'=>$id,'fk_user_type'=>4));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Staff Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_all_appointment_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $this->load->model('superadmin_model');
            $appointment_details = $this->superadmin_model->get_all_appointment_details();      
            foreach ($appointment_details as $appointment_details_key => $appointment_details_row) {
                $documents = $this->model->selectWhereData('tbl_patient_medical_documents',array('fk_appointment_id'=>$appointment_details_row['id']),array('documents'),false);
                $appointment_details[$appointment_details_key]['documents'][] = $documents;
            } 
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['appointment_details_data'] = $appointment_details;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function save_location_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $place_name = $this->input->post('place_name');        
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                if(empty($place_name)){
                    $response['message'] = "Place Name is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{                    
                    $check_contact_no_count = $this->model->CountWhereRecord('tbl_visit_location', array('place_name'=>$place_name,'status'=>1,'del_status'=>1));
                    if($check_contact_no_count > 0){
                        $response['code'] = 201;
                        $response['status'] = false;
                        $response['message'] = 'Place Already exist.';
                    }else{
                        $curl_data =  array(
                            'place_name' => $place_name,              
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'fk_state_id'=>$state,
                            'fk_city_id'=>$city,
                            'pincode'=>$pincode,
                        );
                        $this->model->insertData('tbl_visit_location',$curl_data);
                        $response['code'] = REST_Controller::HTTP_OK;
                        $response['status'] = true;
                        $response['message'] = 'Location Added Successfully';
                    }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function display_all_location_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $this->load->model('superadmin_model');
            $location_details = $this->superadmin_model->get_all_location_details();      
            foreach ($location_details as $location_details_key => $location_details_row) {
                $location_details[$location_details_key]['city_data'] = $this->model->selectWhereData('tbl_cities',array('state_id'=>$location_details_row['fk_state_id']),array('id','city'),false);
            }
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['location_details_data'] = $location_details;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function update_location_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $place_name = $this->input->post('place_name');        
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $pincode = $this->input->post('pincode');
                $id = $this->input->post('id');
                if(empty($place_name)){
                    $response['message'] = "Place Name is required";
                    $response['code'] = 201;
                }else if(empty($address1)){
                    $response['message'] = "Address 1 is required";
                    $response['code'] = 201;
                }else if(empty($state)){
                    $response['message'] = "State is required";
                    $response['code'] = 201;
                }else if(empty($city)){
                    $response['message'] = "City is required";
                    $response['code'] = 201;
                }else if(empty($pincode)){
                    $response['message'] = "Pincode is required";
                    $response['code'] = 201;
                }else{                    
                    $check_contact_no_count = $this->model->CountWhereRecord('tbl_visit_location', array('place_name'=>$place_name,'status'=>1,'del_status'=>1,'id !='=> $id));
                    if($check_contact_no_count > 0){
                        $response['code'] = 201;
                        $response['status'] = false;
                        $response['message'] = 'Place Already exist.';
                    }else{
                        $curl_data =  array(
                            'place_name' => $place_name,              
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'fk_state_id'=>$state,
                            'fk_city_id'=>$city,
                            'pincode'=>$pincode,
                        );
                        $this->model->updateData('tbl_visit_location',$curl_data,array('id'=>$id));
                        $response['code'] = REST_Controller::HTTP_OK;
                        $response['status'] = true;
                        $response['message'] = 'Location Added Successfully';
                    }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function delete_location_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_visit_location',$curl_data,array('id'=>$id));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Location Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

       // =============================== Add Charges==========================
    public function add_charges_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $charges_name = $this->input->post('charges_name');
                if(empty($charges_name)){
                    $response['message'] = "First Name is required";
                    $response['code'] = 201;
                }else{
                        $check_charges_count = $this->model->CountWhereRecord('tbl_charges_type', array('charges_name'=>$charges_name,'del_status'=>1));
                        if($check_charges_count > 0){
                             $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Dieases is Already exist.';
                        }else{                            
                            $curl_data =  array(
                                'charges_name' => $charges_name,
                            );
                            $inserted_id = $this->model->insertData('tbl_charges_type',$curl_data);                       
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Charges Added Successfully';
                        }
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function display_all_charges_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                 $this->load->model('superadmin_model');
                $charges_data = $this->superadmin_model->display_all_charges_details();
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['charges_data'] = $charges_data;
        } else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_charges_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $charges_name = $this->input->post('charges_name');
                $id = $this->input->post('id');
                if(empty($charges_name)){
                    $response['message'] = "charges_name is required";
                    $response['code'] = 201;
                }else{
                    $curl_data =  array(
                        'charges_name' => $charges_name,                       
                    );
                    $this->model->updateData('tbl_charges_type',$curl_data,array('id'=>$id));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Charges Updated Successfully';

                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_charges_status_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if($validate){
            $id = $this->input->post('id');
            $status=$this->input->post('status');
            if (empty($id)) {
                $response['message'] = 'id is required';
                $response['code'] = 201;
            } else {
                $update_data = array(
                    'status'=>$status,
                );
                $this->model->updateData('tbl_charges_type',$update_data, array('id'=>$id));
                $response['message'] = 'Status Changed Successfully';
                $response['code'] = 200;
                $response['status'] = true;
            }
        } else {
            $response['message'] = 'Invalid Request';
            $response['code'] = 204;
        }
        echo json_encode($response);
    }
    public function delete_charges_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                if(empty($id)){
                    $response['message'] = "Id is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'del_status' =>0,
                    );
                    $this->model->updateData('tbl_charges_type',$curl_data,array('id'=>$id));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Charges Deleted Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function s_get_all_appointment_report_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $this->load->model('superadmin_model');
            $appointment_details = $this->superadmin_model->s_get_all_appointment_details();      
            foreach($appointment_details as $appointment_details_key => $appointment_details_row){
                $payment_info = $this->paymentcalculation->calculate_payment($appointment_details_row['id']);
                $appointment_details[$appointment_details_key]['total_charges'] = $payment_info['total_charges'];
                $appointment_details[$appointment_details_key]['total_paid_amount'] = $payment_info['total_paid_amount'];
                $appointment_details[$appointment_details_key]['remaining_amount'] = $payment_info['remaining_amount'];
            }
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
            $response['appointment_details_data'] = $appointment_details;
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
}
?>