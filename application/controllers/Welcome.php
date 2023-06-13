<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function email_template()
    {
        $this->load->view('new_email_template');
    }
    public function invoice()
    {

    	$curl_data=array('id'=>1);
        $curl = $this->link->hits('get-payment-data-on-appointment-id',$curl_data);   
        $curl = json_decode($curl, true);
        $payment_data['payment_detail'] = $curl['payment_detail'];
        ini_set('memory_limit', '256M');
                                                
        // $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";
        $this->load->library('m_pdf');
        $data = $payment_data;
                        // echo '<pre>'; print_r($data); exit;
        $html = $this->load->view('invoice', array('data'=>$data),true);
	    $mpdf = new mPDF();
	    $mpdf->SetDisplayMode('fullpage');
	    $mpdf->AddPage('P', 'A4');
	   
	    $mpdf->WriteHTML($html);
	    ob_end_clean();
	    $mpdf->Output($pdfFilePath, "I");               
        // $this->load->view('invoice');
    }
}
