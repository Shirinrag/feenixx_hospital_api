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

    public function get_all_appointment_details_on_doctor_id_post()
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
                $appointment_details = $this->superadmin_model->get_all_appointment_details_doctor($id);      
                foreach ($appointment_details as $appointment_details_key => $appointment_details_row) {
                    $documents = $this->model->selectWhereData('tbl_patient_medical_documents',array('fk_appointment_id'=>$appointment_details_row['id']),array('documents'),false);
                    $appointment_details[$appointment_details_key]['documents'][] = $documents;
                } 
                $response['code'] = REST_Controller::HTTP_OK;
                $response['status'] = true;
                $response['message'] = 'success';
                $response['appointment_details_data'] = $appointment_details;
            }
            
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function dashboard_count_data_get()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
            $patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1));
            $male_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>1));
            $female_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>2));
            $transgender_patient_count = $this->model->CountWhereInRecord('tbl_patients',array('del_status'=>1,'fk_gender_id'=>3));
            $appointment_count = $this->model->countrecord('tbl_appointment');
            $diseases_count = $this->model->CountWhereInRecord('tbl_diseases',array('del_status'=>1));
            $response['code'] = REST_Controller::HTTP_OK;
            $response['status'] = true;
            $response['message'] = 'success';
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


}
?>