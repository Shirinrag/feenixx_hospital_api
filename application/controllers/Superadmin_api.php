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
                            );
                            $this->model->insertData('tbl_users',$insert_data);
                           
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
                            );
                            $this->model->insertData('tbl_users',$insert_data);
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Doctor Details Added Successfully';
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
                            $response['message'] = 'Doctor Details Updated Successfully';
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
}
?>