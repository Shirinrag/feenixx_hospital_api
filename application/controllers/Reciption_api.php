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
                $document = $this->input->post('document');
                $document = json_decode($document,true);
                $admission_type = $this->input->post('admission_type');
                $admission_sub_type = $this->input->post('admission_sub_type');
                $reference_doctor_name = $this->input->post('reference_doctor_name');
                $admission_type = $this->input->post('admission_type');
                $deposite_amount = $this->input->post('deposite_amount');
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
                else if(empty($admission_type)){
                    $response['message'] = "Admission Type is required";
                    $response['code'] = 201;
                }else{
                    $appointment_count = $this->model->CountWhereInRecord('tbl_appointment',array('fk_patient_id'=>$patient_id,'appointment_date' => $appointment_date,'appointment_time'=>$appointment_time,));
                    if($check_contact_no_count > 0){
                        $response['code'] = 201;
                        $response['status'] = false;
                        $response['message'] = 'Place Already exist.';
                    }else{
                        $curl_data =  array(
                            'fk_doctor_id' => $doctor_id,
                            'fk_patient_id' =>  $patient_id,
                            'fk_diseases_id' => $fk_diseases_id,
                            'appointment_date' => $appointment_date,
                            'appointment_time'=>$appointment_time,
                            'admission_type'=>$admission_type,
                            'reference_doctor_name'=>$reference_doctor_name,
                            'fk_admission_sub_type_id'=>$admission_sub_type
                        );
                        $inserted_id = $this->model->insertData('tbl_appointment',$curl_data);
                        if(!empty($deposite_amount)){
                            $insert_payment_details = array(
                                'deposite_amount'=>$deposite_amount
                            );
                            $this->model->insertData('tbl_payment',$insert_payment_details);
                        }
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
                    $advance_payment_details = $this->superadmin_model->get_all_advance_payment_details_on_appointment_id($appointment_details_row['id']);
                    $appointment_details[$appointment_details_key]['advance_payment_details'][] = $advance_payment_details;
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
                $online_amount = $this->input->post('online_amount');
                $cash_amount = $this->input->post('cash_amount');
                $mediclaim_amount = $this->input->post('mediclaim_amount');
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
                }else{

                    $check_payment_count = $this->model->CountWhereRecord('tbl_payment', array('fk_appointment_id'=>$fk_appointment_id));
                    if($check_payment_count > 0){
                            $response['code'] = 201;
                            $response['status'] = false;
                            $response['message'] = 'Payment Details Already exist.';                  
                        }else{
                            $payment_data = $this->model->selectWhereData('tbl_invoice_no',array(),array('id'));
                            $year = date('Y');
                            if(empty($payment_data)){                
                                    $new_invoice_id  = 'FXH'.$year.'001';
                            }else{
                                    $this->load->model('superadmin_model');
                                    $payment_data = $this->superadmin_model->get_last_invoice_no();
                                    $explode = explode("H",$payment_data['invoice_no']);
                                    $count = 8-strlen($explode[1]+1);
                                    $invoice_rep =$explode[1]+1;                                                          
                                    for($i=0;$i<$count;$i++){
                                        $invoice_rep= $invoice_rep;
                                    }
                                    $new_invoice_id = 'FXH'.$invoice_rep;
                            }
                            $patient_id = $this->model->selectWhereData('tbl_patients',array('id'=>$fk_patient_id),array('patient_id'));
                            $invoice_pdf = base_url() . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";

                            $this->model->updateData('tbl_appointment',array('invoice_pdf'=>$invoice_pdf),array('id'=>$fk_appointment_id));

                            $insert_payment_details = array(
                                'fk_patient_id'=>$fk_patient_id,
                                'fk_appointment_id'=>$fk_appointment_id,
                                'payment_details'=>$payment_details,
                                'added_by'=> $added_by,
                                'invoice_no'=>$new_invoice_id,
                            );
                            $inserted_id = $this->model->insertData('tbl_payment',$insert_payment_details);

                            $insert_payment_history_details = array(
                                'fk_patient_id'=>$fk_patient_id,
                                'fk_appointment_id'=>$fk_appointment_id,
                                'fk_payment_id'=>$inserted_id,
                                'online_amount'=>$online_amount,
                                'cash_amount'=>$cash_amount,
                                'mediclaim_amount'=>$mediclaim_amount,
                                'total_amount'=>$total_amount,
                                'total_paid_amount'=>$total_paid_amount,
                                'remaining_amount'=>$remaining_amount,
                                'date'=>date('d/m/Y'),
                                'added_by'=> $added_by
                            );
                            $this->model->insertData('tbl_payment_history',$insert_payment_history_details); 
                            error_reporting(0);
                            
                            $curl_data=array('id'=>$fk_appointment_id);
                            $curl = $this->link->hits('get-payment-data-on-appointment-id',$curl_data);   
                            $curl = json_decode($curl, true);
                            $payment_data['payment_detail'] = $curl['payment_detail'];
                            ini_set('memory_limit', '256M');
                                                                    
                            $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";
                            $this->load->library('m_pdf');
                            $data = $payment_data;
                            $html = $this->load->view('invoice', array('data'=>$data),true);
                            $mpdf = new mPDF();
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->AddPage('P', 'A4');
                           
                            $mpdf->WriteHTML($html);
                            ob_end_clean();
                            $mpdf->Output($pdfFilePath, "F");     
                                             
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
                    $response['message'] = "Id is required";
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
                    $payment_mode = $this->model->selectWhereData('tbl_payment_type',array('id'=>$payment_details_2['payment_type']),array('payment_type'));
                    $payment_history = $this->model->selectWhereData('tbl_payment_history',array('fk_payment_id'=>$appointment_details['payment_id']),array('amount','mediclaim_amount','total_amount','total_paid_amount','remaining_amount','date'),false);
                    $previous_remaining_amount = $this->model->selectWhereData('tbl_payment_history',array('fk_payment_id'=>$appointment_details['payment_id'],'used_status'=>1),array('remaining_amount'));
                   $advance_payment_details = $this->superadmin_model->get_all_advance_payment_details_on_appointment_id($id);
                   $charges_payment_details = $this->superadmin_model->get_all_charges_payment_details_on_appointment_id($id);
                    $appointment_details['payment_details'] =$payment_details_2;
                    $appointment_details['payment_history'] =$payment_history;
                    $appointment_details['payment_type'] =$payment_mode['payment_type'];
                    $appointment_details['previous_remaining_amount'] =$previous_remaining_amount['remaining_amount'];                   
                    $payment_info = $this->paymentcalculation->calculate_payment($id);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'success';
                    $response['payment_detail'] = $appointment_details;
                    $response['advance_payment'] = $advance_payment_details;
                    $response['charges_payment_details'] = $charges_payment_details;
                    $response['payment_info'] = $payment_info;
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function update_payment_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $fk_payment_id = $this->input->post('fk_payment_id');
                $fk_patient_id = $this->input->post('fk_patient_id');
                $fk_appointment_id = $this->input->post('fk_appointment_id');
                $online_amount = $this->input->post('online_amount');
                $cash_amount = $this->input->post('cash_amount');
                $mediclaim_amount = $this->input->post('mediclaim_amount');
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
                }else{
                    $curl_data = array('used_status'=>0);
                    $this->model->updateData('tbl_payment_history',$curl_data,array('fk_payment_id'=>$fk_payment_id));
                    $insert_payment_history_details = array(
                        'fk_patient_id'=>$fk_patient_id,
                        'fk_appointment_id'=>$fk_appointment_id,
                        'fk_payment_id'=>$fk_payment_id,
                        'online_amount'=>$online_amount,
                        'cash_amount'=>$cash_amount,
                        'mediclaim_amount'=>$mediclaim_amount,
                        'total_amount'=>$total_amount,
                        'total_paid_amount'=>$total_paid_amount,
                        'remaining_amount'=>$remaining_amount,
                        'date'=>date('d/m/Y'),
                        'added_by'=> $added_by
                    );
                    $this->model->insertData('tbl_payment_history',$insert_payment_history_details);
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Payment Details Added Successfully';                  
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function add_appointment_advance_payment_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $added_by = $this->input->post('added_by');
                $fk_patient_id = $this->input->post('fk_patient_id');
                $fk_appointment_id = $this->input->post('fk_appointment_id');
                $advance_amount = $this->input->post('advance_amount');
                $advance_amount = json_decode($advance_amount,true);
                $fk_payment_type = $this->input->post('fk_payment_type');
                $fk_payment_type = json_decode($fk_payment_type,true);
                $advance_payment_date = $this->input->post('advance_payment_date');
                $advance_payment_date = json_decode($advance_payment_date,true);
    
                if(empty($fk_appointment_id)){
                    $response['message'] = "Appointment Id is required";
                    $response['code'] = 201;
                }else if(empty($fk_patient_id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else if(empty($advance_amount[0])){
                    $response['message'] = "Amount is required";
                    $response['code'] = 201;
                }else if(empty($fk_payment_type[0])){
                    $response['message'] = "Payment Type is required";
                    $response['code'] = 201;
                }else if(empty($advance_payment_date[0])){
                    $response['message'] = "Payment Date is required";
                    $response['code'] = 201;
                }else{
                    $this->load->model('superadmin_model');
                    $patient_id = $this->model->selectWhereData('tbl_patients',array('id'=>$fk_patient_id),array('patient_id'));
                    

                    foreach ($advance_amount as $advance_amount_key =>    $advance_amount_row) {

                           $invoice_date_1 = $advance_payment_date[$advance_amount_key];
                           $invoice_date_11 = str_replace("-", "_", $invoice_date_1);
                           $invoice_date_12 = $invoice_date_11."_".date("h_i_s");

                        $payment_data = $this->model->selectWhereData('tbl_invoice_no',array(),array('id'));
                            $year = date('Y');
                            if(empty($payment_data)){                
                                    $new_invoice_id  = 'FXH'.$year.'001';
                            }else{
                                    $this->load->model('superadmin_model');

                                    $payment_data = $this->superadmin_model->get_last_invoice_no();
                                    $explode = explode("H",$payment_data['invoice_no']);
                                    $count = 8-strlen($explode[1]+1);
                                    $invoice_rep =$explode[1]+1;                                                          
                                    for($i=0;$i<$count;$i++){
                                        $invoice_rep= $invoice_rep;
                                    }
                                    $new_invoice_id = 'FXH'.$invoice_rep;
                            }
                             $invoice_pdf = base_url() . "uploads/invoice/".$patient_id['patient_id']."_advance_invoice_".$invoice_date_12.".pdf";

                            $this->model->updateData('tbl_appointment',array('invoice_pdf'=>$invoice_pdf),array('id'=>$fk_appointment_id));
                             $insert_advance_payment = array(
                                'fk_patient_id'=>$fk_patient_id,
                                'fk_appointment_id'=>$fk_appointment_id,
                                'fk_payment_id'=>$fk_payment_type[$advance_amount_key],
                                'amount'=>$advance_amount_row,
                                'total_amount'=>$advance_amount_row,
                                'date'=>$advance_payment_date[$advance_amount_key],
                                'invoice_no'=>$new_invoice_id,
                                'invoice_pdf'=>$invoice_pdf,
                                'is_advance'=>1,
                                'used_status'=>1,
                                'added_by'=>$added_by,
                            );
                            $inserted_id = $this->model->insertData('tbl_payment_history',$insert_advance_payment);
                            
                            $invoice_no_insert = array('invoice_no'=>$new_invoice_id);

                            $this->model->insertData("tbl_invoice_no",$invoice_no_insert);

                            $advance_payment_details = $this->superadmin_model->get_advanced_payment_data($inserted_id);
                            error_reporting(0);
                            ini_set('memory_limit', '256M');                  
                            $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_advance_invoice_".$invoice_date_12.".pdf";
                                                        
                             $this->load->library('m_pdf');
                            $data = $advance_payment_details;
                                            // echo '<pre>'; print_r($data); exit;
                            $html = $this->load->view('advance_invoice', array('data'=>$data),true);
                            $mpdf = new mPDF();
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->AddPage('P', 'A4');
                           
                            $mpdf->WriteHTML($html);
                            ob_end_clean();
                            $mpdf->Output($pdfFilePath, "F");   

                            // $this->load->library('Pdf');

                            // $pdf = new Pdf();
                            // $data = $advance_payment_details;
                            // $html = $this->load->view('advance_invoice', array('data'=>$data),true);
                            // // $pdf->SetTitle('Pdf Example');
                            // $pdf->SetHeaderMargin(30);
                            // $pdf->SetTopMargin(20);
                            // $pdf->setFooterMargin(20);
                            // $pdf->SetAutoPageBreak(true);
                            // // $pdf->SetAuthor('Author');
                            // $pdf->SetDisplayMode('real', 'default');
                            // $pdf->AddPage();
                            // $pdf->writeHTML($html, true, false, true, false, '');
                            // $pdf->Output($pdfFilePath, "F");

                            
                    }
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Advance Payment Added Successfully';                  
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function add_appointment_charges_details_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $fk_patient_id = $this->input->post('fk_patient_id');
                $fk_appointment_id = $this->input->post('fk_appointment_id');
                $charges = $this->input->post('charges');
                $charges = json_decode($charges,true);
                $amount = $this->input->post('amount');
                $amount = json_decode($amount,true);
                $total_amount = $this->input->post('total_amount');
                $total_amount = json_decode($total_amount,true);
                $no_of_count = $this->input->post('no_of_count');
                $no_of_count = json_decode($no_of_count,true);
                $dr_name = $this->input->post('dr_name');
                $dr_name = json_decode($dr_name,true);
                $date = $this->input->post('date');
                $date = json_decode($date,true);
                if(empty($fk_appointment_id)){
                    $response['message'] = "Appointment Id is required";
                    $response['code'] = 201;
                }else if(empty($fk_patient_id)){
                    $response['message'] = "Patient Id is required";
                    $response['code'] = 201;
                }else if(empty($charges[0])){
                    $response['message'] = "Amount is required";
                    $response['code'] = 201;
                }else if(empty($amount[0])){
                    $response['message'] = "Payment Type is required";
                    $response['code'] = 201;
                }else if(empty($total_amount[0])){
                    $response['message'] = "Payment Type is required";
                    $response['code'] = 201;
                }else if(empty($date[0])){
                    $response['message'] = "Date is required";
                    $response['code'] = 201;
                }else{
                    foreach ($charges as $charges_key => $charges_row) {
                         $curl_data = array(
                            'fk_patient_id'=>$fk_patient_id,
                            'fk_appointment_id'=>$fk_appointment_id,
                            'fk_charges_type_id'=>$charges_row,
                            'date'=>$date[$charges_key],
                            'amount'=>$amount[$charges_key],
                            'no_of_count'=>$no_of_count[$charges_key],
                            'total_amount'=>$total_amount[$charges_key],
                            'dr_name'=>$dr_name[$charges_key],
                        );
                        $this->model->insertData('tbl_charges',$curl_data);
                    }
                    $final_invoice = generate_final_invoice_pdf($fk_appointment_id);

                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Charges Added Successfully';
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }
    public function update_discharge_date_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $id = $this->input->post('id');
                $date_of_discharge = $this->input->post('date_of_discharge');
                if(empty($id)){
                    $response['message'] = "Appointment Id is required";
                    $response['code'] = 201;
                }else if(empty($date_of_discharge)){
                    $response['message'] = "Date of Discharge is required";
                    $response['code'] = 201;
                }else{
                    $curl_data = array(
                        'date_of_discharge'=>$date_of_discharge
                    );
                    $this->model->updateData('tbl_appointment',$curl_data,array('id'=>$id));

                    $final_invoice = generate_final_invoice_pdf($id);                    
                    $response['code'] = REST_Controller::HTTP_OK;
                    $response['status'] = true;
                    $response['message'] = 'Discharge Date is Updated Successfully';                  
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function update_discharge_summary_post()
    {
        $response = array('code' => - 1, 'status' => false, 'message' => '');
        $validate = validateToken();
        if ($validate) {
                $update_appointment_id = $this->input->post('update_appointment_id');
                $discharge_summary = $this->input->post('discharge_summary');
                if(empty($update_appointment_id)){
                    $response['message'] = "Appointment Id is required";
                    $response['code'] = 201;
                }else if(empty($discharge_summary)){
                    $response['message'] = "Date of Discharge is required";
                    $response['code'] = 201;
                }else{
                            $fk_patient_id = $this->model->selectWhereData('tbl_appointment',array('id'=>$update_appointment_id),array('fk_patient_id'));
                            $patient_id = $this->model->selectWhereData('tbl_patients',array('id'=>$fk_patient_id['fk_patient_id']),array('patient_id'));
                                    $invoice_date_1 = date('d-m-Y');
                                   $invoice_date_11 = str_replace("-", "_", $invoice_date_1);
                                   $invoice_date_12 = $invoice_date_11."_".date("h_i_s");

                            $discharge_summary_pdf = base_url() . "uploads/".$patient_id['patient_id']."_discharge_summary_".$invoice_date_12.".pdf";
                            $curl_data = array(
                                'discharge_summary'=>$discharge_summary,
                                'discharge_summary_pdf'=>$discharge_summary_pdf,
                            );
                            $this->model->updateData('tbl_appointment',$curl_data,array('id'=>$update_appointment_id));

                            $pdfFilePath = FCPATH . "uploads/".$patient_id['patient_id']."_discharge_summary_".$invoice_date_12.".pdf";

                            $this->load->model('superadmin_model');
                            $discharge_summary_data = $this->superadmin_model->discharge_summary_details($update_appointment_id);
                             error_reporting(0);
                            ini_set('memory_limit', '256M'); 
                            // $this->load->library('Pdf');
                            // $pdf = new Pdf();
                            // $data = $discharge_summary_data;
                            // $html = $this->load->view('discharge_summary', array('data'=>$data),true);
                            // $pdf->SetTitle('Pdf Example');
                            // $pdf->SetHeaderMargin(30);
                            // $pdf->SetTopMargin(20);
                            // $pdf->setFooterMargin(20);
                            // $pdf->SetAutoPageBreak(true);
                            // // $pdf->SetAuthor('Author');
                            // $pdf->SetDisplayMode('real', 'default');
                            // $pdf->AddPage();
                            // $pdf->writeHTML($html, true, false, true, false, '');
                            // ob_clean();
                            // $pdf->Output($pdfFilePath, "F");

                            $this->load->library('m_pdf');
                            $data = $discharge_summary_data;
                            $html = $this->load->view('discharge_summary', array('data'=>$data),true);
                            $mpdf = new mPDF();
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->AddPage('P', 'A4');                           
                            $mpdf->WriteHTML($html);
                            ob_end_clean();
                            $mpdf->Output($pdfFilePath, "F");

                            $response['code'] = REST_Controller::HTTP_OK;
                            $response['status'] = true;
                            $response['message'] = 'Discharge Summary Added Successfully';                  
                }
        }else {
            $response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
        }
        echo json_encode($response);
    }

    public function invoice_get()
    {

        // $curl_data=array('id'=>1);
        //                     $curl = $this->get_payment_data_on_appointment_id($curl_data);
        //                     $payment_data['payment_detail'] = $curl['payment_detail'];

                        // ini_set('memory_limit', '256M');
                                                
                        // $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";
                        // $this->load->library('m_pdf');
                        // $data = $payment_data;
                        // echo '<pre>'; print_r($data); exit;
                         // $this->load->view('advance_invoice');
                        // $mpdf = new mPDF();
                        // $mpdf->SetDisplayMode('fullpage');
                        // $mpdf->AddPage('P', 'A4');
                       
                        // $mpdf->WriteHTML($html);
                        // ob_end_clean();
                        // $mpdf->Output($pdfFilePath, "F");               
        $this->load->view('welcome_message');
    }


}