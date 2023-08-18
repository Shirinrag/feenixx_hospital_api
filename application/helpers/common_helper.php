<?php
 function token_get(){
    $tokenData = array();
    $tokenData['id'] = mt_rand(10000,99999); //TODO: Replace with data for token
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    return $output['token'];
}
function dec_enc($action, $string)
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'feenixx_hospital key';
    $secret_iv = 'feenixx_hospital iv';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } elseif ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
function generateOTP() {
    return mt_rand(1000,9999);
}
function generatePassword() {
    $length = 8;
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($chars), 0, $length);
    // $pass = encrypt($password);
    return $password;
}

function generate_varchar_string($strength = '') {
        $input = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
        }
        return $random_string;
}
function generate_request_id($tbl_name='',$column_name='')
    {
        $CI = get_instance();
        $varchar = generate_varchar_string(2);
        $rand = mt_rand(1000000, 9999999);
        $randTemp = $varchar.$rand;
        $isUnique = true;
        do {
            if(empty($tbl_name)){
                $tbl_name = 'tbl_user_pass_details';
            }
            if(empty($column_name)){
                $column_name = 'ref_request_id';
            }
            $result = $CI->db->get_where($tbl_name, array($column_name => $randTemp));
            if ($result->num_rows() > 0) {
                $isUnique = false;
            } else {
                $isUnique = true;
            }
        } while ($isUnique == false);
        return $randTemp;
    }

    function random_strings() 
    { 
        $CI = get_instance();
        $varchar = generate_varchar_string(4);
        $rand = mt_rand(1000000, 9999999);
        $randTemp = $varchar.$rand;
        $isUnique = true;
        do {
            $result = $CI->db->get_where('tbl_patients', array('patient_id' => $randTemp));
            if ($result->num_rows() > 0) {
                $isUnique = false;
            } else {
                $isUnique = true;
            }
        } while ($isUnique == false);
        return $randTemp;
    }
    function serial_no()
    {
        $CI = get_instance();
        $serial_no = 000001;
        do {
            $result = $CI->db->get_where('tbl_appointment', array('receipt_no' => $serial_no));
            if ($result->num_rows() > 0) {
                $isUnique = false;
            } else {
                $isUnique = $serial_no + 1;
            }
        } while ($isUnique == false);
        return $isUnique;
    }
    function send_email($to="",$subject="",$message="",$attach=''){
        // error_reporting(0);
        $from = " noreply@feenixxhospitals.com";
        $CI = get_instance();
        $CI->load->library('email');
        $email_data = $CI->load->view('new_email_template', $message, true);
        $CI->email->set_mailtype("html");
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        $CI->email->attach($attach);
        $CI->email->send();
}
function generate_invoice_no()
{
    $CI = get_instance();
    $invoice_data = $CI->model->selectWhereData('tbl_invoice_no',array(),array('id'));
    $year = date('Y');
    if(empty($invoice_data)){                
            $new_invoice_id  = 'FXH'.$year.'001';
    }else{
            $CI->load->model('superadmin_model');

            $payment_data = $CI->superadmin_model->get_last_invoice_no();
            $explode = explode("H",$payment_data['invoice_no']);
            $count = 8-strlen($explode[1]+1);
            $invoice_rep =$explode[1]+1;                                                          
            for($i=0;$i<$count;$i++){
                $invoice_rep= $invoice_rep;
            }
            $new_invoice_id = 'FXH'.$invoice_rep;
    }
    return $new_invoice_id;
}
function generate_final_invoice_pdf($id='')
{
     $CI = get_instance();
     ini_set('memory_limit', '256M');
     $CI->load->model('superadmin_model');
     $date_of_discharge = $CI->model->selectWhereData('tbl_appointment',array('id'=>$id),array('*'));
     $charges_data = $CI->superadmin_model->get_final_invoice_details($id);
     $final_charges_draft = [];
     $is_discharge_done = false;
     $invoice_date_1 = date('d-m-Y');
     $invoice_date_11 = str_replace("-", "_", $invoice_date_1);
     $invoice_date_12 = $invoice_date_11."_".date("h_i_s");
     foreach ($charges_data as $charges_data_key => $charges_data_row) {
        $final_charges_amount = 0;
        $final_charges_count = 0;
        $charges_amount_1 = $charges_data_row['charges_amount']; 
        $charges_amount_explode = explode(',',$charges_amount_1);
        $charges_count_1 = $charges_data_row['charges_count']; 
        $charges_count_explode = explode(',',$charges_count_1);
        $date_count_1 = $charges_data_row['date']; 
        $date_count_explode = explode(',',$date_count_1);
        $last_date = end($date_count_explode);
        foreach ($charges_amount_explode as $charges_amount_explode_key => $charges_amount_explode_row) {
            $total_charges_amount =  $charges_amount_explode_row * $charges_count_explode[$charges_amount_explode_key];
            $single_price_unit = $charges_amount_explode[0]/$charges_count_explode[0];
            $final_charges_amount = $total_charges_amount+$final_charges_amount;
            $final_charges_count = $final_charges_count+$charges_count_explode[$charges_amount_explode_key];
        }
        if($last_date ==$date_of_discharge['date_of_discharge']){
            $is_discharge_done = true;
        }
        $charges_data[$charges_data_key]['single_price_unit'] = $single_price_unit;
        $charges_data[$charges_data_key]['final_amount'] = $final_charges_amount;
        $charges_data[$charges_data_key]['final_count'] = $final_charges_count;
     }
     $doctor_data = $CI->model->selectWhereData('tbl_doctor',array('id'=>$date_of_discharge['fk_doctor_id']),array('first_name','last_name'));
     $surgery_details = $CI->model->selectWhereData('tbl_surgery_details',array('fk_appointment_id'=>$id),array('GROUP_CONCAT(surgery_date) as surgery_date'),true,'','fk_appointment_id');
      $payment_info = $CI->paymentcalculation->calculate_payment($id);
     $details['invoice_no'] = generate_invoice_no();
     $details['date_of_discharge'] =$date_of_discharge;
     $details['charges_data'] =$charges_data;
     $details['doctor_data'] =$doctor_data;
     $details['payment_data'] =$payment_info;
     $details['surgery_details'] =$surgery_details;
     $details['date'] = date('d-m-Y');
     $details['diseases'] = $CI->superadmin_model->get_patient_disease_details($id);
     // foreach ($charges_data as $charges_data_key => $charges_data_row) {
        // if($is_discharge_done){ 
        //     $CI->load->library('Pdf');
        //     $pdfFilePath = FCPATH . "uploads/invoice/".@$charges_data[0]['patient_id']."_invoice.pdf";
        //     $pdf = new Pdf();
        //     $html = $CI->load->view('invoice', array('data'=>$details),true);
        //     // $pdf->SetTitle('Pdf Example');
        //     $pdf->SetHeaderMargin(30);
        //     $pdf->SetTopMargin(20);
        //     $pdf->setFooterMargin(20);
        //     $pdf->SetAutoPageBreak(true);
        //     // $pdf->SetAuthor('Author');
        //     $pdf->SetDisplayMode('real', 'default');
        //     $pdf->AddPage();
        //     $pdf->writeHTML($html, true, false, true, false, '');
        //     $pdf->Output($pdfFilePath, "F");
        // }
        if($date_of_discharge['admission_type']==2 && $is_discharge_done){          
                 
                $pdfFilePath = FCPATH . "uploads/invoice/".@$charges_data[0]['patient_id']."_".$invoice_date_12."_invoice.pdf";
                $CI->load->library('m_pdf');
                $html = $CI->load->view('invoice', array('data'=>$details),true);
                $mpdf = new mPDF();
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->AddPage('P', 'A4');
                $mpdf->WriteHTML($html);
                ob_end_clean();
                $mpdf->Output($pdfFilePath, "F");  
                $pdf = base_url()."uploads/invoice/".@$charges_data[0]['patient_id']."_".$invoice_date_12."_invoice.pdf";
                 $curl_data = array('invoice_pdf'=>$pdf);
                 $CI->model->updateData('tbl_appointment',$curl_data,array('id'=>$id));
                 $invoice_no = $details['invoice_no'];
                 $insert_invoice_no = array('invoice_no'=>$invoice_no);
                 $CI->model->insertData('tbl_invoice_no',$insert_invoice_no);
            // $CI->load->library('Pdf');
            //     $pdfFilePath = FCPATH . "uploads/invoice/".@$charges_data[0]['patient_id']."_invoice.pdf";
            //     $pdf = new Pdf();
            //     $html = $CI->load->view('invoice', array('data'=>$details),true);
            //     // $pdf->SetTitle('Pdf Example');
            //     $pdf->SetHeaderMargin(30);
            //     $pdf->SetTopMargin(20);
            //     $pdf->setFooterMargin(20);
            //     $pdf->SetAutoPageBreak(true);
            //     // $pdf->SetAuthor('Author');
            //     $pdf->SetDisplayMode('real', 'default');
            //     $pdf->AddPage();
            //     $pdf->writeHTML($html, true, false, true, false, '');
            //     $pdf->Output($pdfFilePath, "F");
        }
        else if($date_of_discharge['admission_type']== 1){             
                $pdfFilePath = FCPATH . "uploads/invoice/".@$charges_data[0]['patient_id']."_".$invoice_date_12."_invoice.pdf";
                $CI->load->library('m_pdf');
                $data = $details;
                $html = $CI->load->view('invoice', array('data'=>$data),true);
                $mpdf = new mPDF();
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->AddPage('P', 'A4');
                $mpdf->WriteHTML($html);
                ob_end_clean();
                $mpdf->Output($pdfFilePath, "F");

                $pdf = base_url()."uploads/invoice/".@$charges_data[0]['patient_id']."_".$invoice_date_12."_invoice.pdf";
                 $curl_data = array('invoice_pdf'=>$pdf);
                 $CI->model->updateData('tbl_appointment',$curl_data,array('id'=>$id));
                 $invoice_no = $details['invoice_no'];
                 $insert_invoice_no = array('invoice_no'=>$invoice_no);
                 $CI->model->insertData('tbl_invoice_no',$insert_invoice_no);
                // $CI->load->library('Pdf');
                // $pdfFilePath = FCPATH . "uploads/invoice/".@$charges_data[0]['patient_id']."_invoice.pdf";
                // $pdf = new Pdf();
                // $html = $CI->load->view('invoice', array('data'=>$details),true);
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
     // }
     
}