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
//     	 $this->load->library('Pdf');

//     	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
// $pdf->SetTitle('Pdf Example');
// $pdf->SetHeaderMargin(30);
// $pdf->SetTopMargin(20);
// $pdf->setFooterMargin(20);
// $pdf->SetAutoPageBreak(true);
// $pdf->SetAuthor('Author');
// $pdf->SetDisplayMode('real', 'default');
// $pdf->Write(5, 'CodeIgniter TCPDF Integration');
// $pdf->Output('pdfexample.pdf', 'I');
    	// $curl_data=array('id'=>1);
    	// $this->load->model('superadmin_model');
        //  $advance_payment_details = $this->superadmin_model->get_advanced_payment_data(1);   
        
        // ini_set('memory_limit', '256M');
                                                
        // // $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";
        // $this->load->library('m_pdf');
        // $data = $advance_payment_details;
        //                 // echo '<pre>'; print_r($data); exit;
        // $html = $this->load->view('advance_invoice', array('data'=>$data),true);
	    // $mpdf = new mPDF();
	    // $mpdf->SetDisplayMode('fullpage');
	    // $mpdf->AddPage('P', 'A4');
	   
	    // $mpdf->WriteHTML($html);
	    // ob_end_clean();
	    // $mpdf->Output($pdfFilePath, "I");               
        // $this->load->view('advance_invoice');
    }
}
