<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';

class Reciption_api extends REST_Controller {

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
    public function save_appointment_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $doctor_id = $this->input->post('doctor_id');
                $patient_id = $this->input->post('patient_id');
                $appointment_time = $this->input->post('appointment_time');
                $appointment_date = $this->input->post('appointment_date');
                $fk_diseases_id = $this->input->post('fk_diseases_id');
                $payment_type = $this->input->post('payment_type');
                // $description = $this->input->post('description');
                // $cash_amount = $this->input->post('cash_amount');
                // $online_amount = $this->input->post('online_amount');
                // $mediclaim_amount = $this->input->post('mediclaim_amount');
                // $discount = $this->input->post('discount');
                // $total_amount = $this->input->post('total_amount');
                // $image = $this->input->post('image');              
                $document = $this->input->post('document');
                $document = json_decode($document,true);
                $admission_type = $this->input->post('admission_type');
                $admission_sub_type = $this->input->post('admission_sub_type');
                $reference_doctor_name = $this->input->post('reference_doctor_name');
                $admission_type = $this->input->post('admission_type');
                if(empty($doctor_id)){
                    $response['message'] = "Doctor Id is required";
                    $response['code'] = 201;
                }else if(empty($patient_id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else if(empty($appointment_date)){
                    $response['message'] = "Appointment Date is required";
                    $response['code'] = 201;
                }else if(empty($appointment_time)){
                    $response['message'] = "Appointment Time is required";
                    $response['code'] = 201;

                }
                // else if(empty($fk_diseases_id)){
                //     $response['message'] = "Diseases is required";
                //     $response['code'] = 201;
                // }else if(empty($payment_type)){
                //     $response['message'] = "Payment Type is required";
                //     $response['code'] = 201;
                // }else if(empty($description)){
                //     $response['message'] = "Description is required";
                //     $response['code'] = 201;
                // }else if(empty($cash_amount)){
                //     $response['message'] = "Cash Amount is required";
                //     $response['code'] = 201;
                // }else if(empty($online_amount)){
                //     $response['message'] = "Online Amount is required";
                //     $response['code'] = 201;
                // }else if(empty($mediclaim_amount)){
                //     $response['message'] = "Mediclaim Amount is required";
                //     $response['code'] = 201;
                // }else if(empty($discount)){
                //     $response['message'] = "Discount Amount is required";
                //     $response['code'] = 201;
                // }else if(empty($total_amount)){
                //     $response['message'] = "Total Amount is required";
                //     $response['code'] = 201;
                // }
                else if(empty($admission_type)){
                    $response['message'] = "Admission Type is required";
                    $response['code'] = 201;
                }else if(empty($admission_type)){
                    $response['message'] = "Admission Type is required";
                    $response['code'] = 201;
                }else{
                    $curl_data =  array(
                        'fk_doctor_id' => $doctor_id,
                        'fk_patient_id' =>  $patient_id,
                        'fk_diseases_id' => $fk_diseases_id,
                        'appointment_date' => $appointment_date,
                        'appointment_time'=>$appointment_time,
                        // 'prescription'=>$image,
                        // 'description'=>$description,
                        'admission_type'=>$admission_type,
                        'reference_doctor_name'=>$reference_doctor_name,
                        'fk_admission_sub_type_id'=>$admission_sub_type
                    );
                    $inserted_id = $this->model->insertData('tbl_appointment',$curl_data);
                    // $insert_payment_details = array(
                    //     'fk_patient_id'=>$patient_id,
                    //     'fk_appointment_id'=>$inserted_id,
                    //     'payment_type'=>$payment_type,
                    //     'online_amount'=>$online_amount,
                    //     'cash_amount'=>$cash_amount,
                    //     'mediclaim_amount'=>$mediclaim_amount,
                    //     'discount_amount'=>$discount,
                    //     'total_amount'=>$total_amount,
                    // );
                    // $this->model->insertData('tbl_payment',$insert_payment_details);

                    if(!empty($document[0])){
                        foreach ($document as $document_key => $document_row) {
                            $insert_patient_medical_documents_data=array(
                                'fk_patient_id'=>$patient_id,
                                'fk_appointment_id' => $inserted_id,
                                'documents' =>  $document_row,
                            );
                            $this->model->insertData('tbl_patient_medical_documents',$insert_patient_medical_documents_data);
                        } 
                    }                                
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Appointment Details Added Successfully';
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

    public function add_appointment_payment_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $fk_patient_id = $this->input->post('fk_patient_id');
                $fk_appointment_id = $this->input->post('fk_appointment_id');
                $payment_details = $this->input->post('payment_details');               
                $total_amount = $this->input->post('total_amount');
                $total_paid_amount = $this->input->post('total_paid_amount');
                $remaining_amount = $this->input->post('remaining_amount');
                $added_by = $this->input->post('added_by');
                        
                if(empty($fk_appointment_id)){
                    $response['message'] = "Appointment Id is required";
                    $response['code'] = 201;
                }else if(empty($fk_patient_id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else if(empty($total_amount)){
                    $response['message'] = "Total Amount is required";
                    $response['code'] = 201;
                }else if(empty($total_paid_amount)){
                    $response['message'] = "Total Paid Amount is required";
                    $response['code'] = 201;
                }else if(empty($remaining_amount)){
                    $response['message'] = "Total Remaining Amount is required";
                    $response['code'] = 201;
                }else{

                    $check_contact_no_count = $this->model->CountWhereRecord('tbl_payment', array('fk_appointment_id'=>$fk_appointment_id));
                    if($check_contact_no_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Payment Details Already exist.';                  
                        }else{
                            $insert_payment_details = array(
                                'fk_patient_id'=>$fk_patient_id,
                                'fk_appointment_id'=>$fk_appointment_id,
                                'payment_details'=>$payment_details,
                                'added_by'=> $added_by
                            );
                            $inserted_id = $this->model->insertData('tbl_payment',$insert_payment_details);

                            $insert_payment_history_details = array(
                                'fk_patient_id'=>$fk_patient_id,
                                'fk_appointment_id'=>$fk_appointment_id,
                                'fk_payment_id'=>$inserted_id,
                                'total_amount'=>$total_amount,
                                'total_paid_amount'=>$total_paid_amount,
                                'remaining_amount'=>$remaining_amount,
                                'date'=>date('d/m/Y'),
                            );
                            $this->model->insertData('tbl_payment_history',$insert_payment_history_details);
                                                            
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Payment Details Added Successfully';
                        }                    
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function reschedule_appointment_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                $appointment_date = $this->input->post('appointment_date');
                $appointment_time = $this->input->post('appointment_time');               
                if(empty($id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else if(empty($appointment_date)){
                    $response['message'] = "Appointment Date is required";
                    $response['code'] = 201;
                }else if(empty($appointment_time)){
                    $response['message'] = "Appointment Time is required";
                    $response['code'] = 201;
                }else{

                    $check_contact_no_count = $this->model->CountWhereRecord('tbl_appointment', array('appointment_date'=>$appointment_date,'appointment_time'=>$appointment_time,'id !='=>$id));
                    if($check_contact_no_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Appointment Booking Already Exist.';                  
                        }else{
                            $curl_data = array(
                                'appointment_date'=>$appointment_date,
                                'appointment_time'=>$appointment_time
                            );
                            $this->model->updateData('tbl_appointment',$curl_data,array('id'=>$id));                                                            
                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Appointment Rescheduled Successfully';
                        }                    
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function get_payment_data_on_appointment_id_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');               
                if(empty($id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else{
                    $this->load->model('superadmin_model');
                    $appointment_details = $this->superadmin_model->get_payment_data_on_appointment_id($id);
                    $payment_details = $appointment_details['payment_details'];
                    $payment_details_1 = json_decode($payment_details);
                    $payment_details_2 = json_decode(json_encode($payment_details_1), true);
                    foreach ($payment_details_2['charges'] as $payment_details_2_key => $payment_details_2_row) {
                       $charges_type = $this->model->selectWhereData('tbl_charges_type',array('id'=>$payment_details_2_row),array('charges_name'));                    
                       $payment_details_2['charges_name'][$payment_details_2_key] = $charges_type['charges_name'];
                    }
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['payment_details'] = $payment_details_2;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
}