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

function generate_final_invoice_pdf($id='')
{
   
}