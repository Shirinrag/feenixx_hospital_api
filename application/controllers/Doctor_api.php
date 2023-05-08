<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Doctor_api extends REST_Controller {

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
    public function get_patient_details_on_patient_id_post()
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
                    $patient_data = $this->superadmin_model->get_patient_details_on_patient_id($id);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['patient_data'] = $patient_data;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
}
?>