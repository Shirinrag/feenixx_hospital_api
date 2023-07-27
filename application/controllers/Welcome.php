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
    	// // error_reporting(0);
    	// 			$this->load->model('superadmin_model');
		// 		 $discharge_summary_data = $this->superadmin_model->discharge_summary_details(3);
        //                     $this->load->library('Pdf');
        //                     $pdf = new Pdf();
        //                     $data = $discharge_summary_data;
        //                     $html = $this->load->view('discharge_summary', array('data'=>$data),true);
        //                     // $pdf->SetTitle('Pdf Example');
        //                     $pdf->SetHeaderMargin(30);
        //                     $pdf->SetTopMargin(20);
        //                     $pdf->setFooterMargin(20);
        //                     $pdf->SetAutoPageBreak(true);
        //                     // $pdf->SetAuthor('Author');
        //                     $pdf->SetDisplayMode('real', 'default');
        //                     $pdf->AddPage();
        //                     $pdf->writeHTML($html, true, false, true, false, '');
        //                     $pdf->Output($pdfFilePath, "I");

        
      //   ini_set('memory_limit', '256M');
                                                
      //   // $pdfFilePath = FCPATH . "uploads/invoice/".$patient_id['patient_id']."_invoice.pdf";
      //   $this->load->library('m_pdf');
      //   $data = $discharge_summary_data;
      //                   // echo '<pre>'; print_r($data); exit;
      // $html = $this->load->view('discharge_summary', array('data'=>$data),true);
	  //   $mpdf = new mPDF();
	  //   $mpdf->SetDisplayMode('fullpage');
	  //   $mpdf->AddPage('P', 'A4');
	   
	  //   $mpdf->WriteHTML($html);
	  //   ob_end_clean();
	  //   $mpdf->Output($pdfFilePath, "I");               
        // $this->load->view('discharge_summary');


     $this->load->model('superadmin_model');
     $charges_data = $this->superadmin_model->get_final_invoice_details(3);
     $date_of_discharge = $this->model->selectWhereData('tbl_appointment',array('id'=>3),array('*'));
     $patient_data = $this->model->selectWhereData('tbl_patients',array('id'=>$date_of_discharge['fk_patient_id']),array('patient_id','first_name','last_name'));
     $doctor_data = $this->model->selectWhereData('tbl_doctor',array('id'=>$date_of_discharge['fk_doctor_id']),array('first_name','last_name'));
      $payment_info = $this->paymentcalculation->calculate_payment(3);
     $details['invoice_no'] = generate_invoice_no();
     $details['date_of_discharge'] =$date_of_discharge;
     $details['charges_data'] =$charges_data;
     $details['patient_data'] =$patient_data;
     $details['doctor_data'] =$doctor_data;
     $details['payment_data'] =$payment_info;
     $details['date'] = date('d-m-Y');
     foreach ($charges_data as $charges_data_key => $charges_data_row) {
         if($charges_data_row['date'] ==$date_of_discharge['date_of_discharge']){
                            ini_set('memory_limit', '256M');                  
                            $pdfFilePath = FCPATH . "uploads/invoice/".$patient_data['patient_id']."_invoice.pdf";
                            $this->load->library('m_pdf');
                            $data = $details;
                                            // echo '<pre>'; print_r($data); exit;
                            $html = $this->load->view('invoice', array('data'=>$data),true);
                            $mpdf = new mPDF();
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->AddPage('P', 'A4');
                           
                            $mpdf->WriteHTML($html);
                            ob_end_clean();
                            $mpdf->Output($pdfFilePath, "I");  
         }
     }
    }
}
