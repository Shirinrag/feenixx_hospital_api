<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Superadmin extends REST_Controller {

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
                $address = $this->input->post('address');
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
                            $user_type = $this->model->selectWhereData('tbl_user_type',array('user_type'=>"Doctor"),array('id'));
                            $curl_data =  array(
                                'first_name' => $first_name,
                                'last_name' =>  $last_name,
                                'email' => $email,
                                'contact_no' => $phone_no,
                                'password' => dec_enc('encrypt',$password),
                                'fk_user_type'=>$user_type['id'],
                                'specialization'=>$specialization,
                                'address'=>$address,
                                'image'=>$profile_image

                            );
                            $inserted_id = $this->model->insertData('tbl_users',$curl_data);
                           
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
    public function display_all_doctor_details_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
               $this->load->model('superadmin_model');
                $doctor_data = $this->superadmin_model->display_all_doctor_details();
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['doctor_data'] = $doctor_data;
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
                    $doctor_details = $this->model->selectWhereData('tbl_users',array('id'=>$id),array('*'));
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['doctor_details_data'] = $doctor_details;
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
                $address = $this->input->post('address');
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
                        $user_data = $this->model->selectWhereData('tbl_users',array('id'=>$id),array('image'));
                        if(empty($profile_image)){
                            $profile_image1 = $user_data['image'];
                        }else{
                            $profile_image1 = $profile_image;
                        }
                        $curl_data =  array(
                            'first_name' => $first_name,
                            'last_name' =>  $last_name,
                            'address' => $address,
                            'image' => $profile_image1,
                        );
                        $this->model->updateData('tbl_users',$curl_data,array('id'=>$id));
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
                    'login_status'=>$status,
                );
                $this->model->updateData('tbl_users',$update_data, array('id'=>$id));
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
                    $this->model->updateData('tbl_users',$curl_data,array('id'=>$id));
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
}
?>