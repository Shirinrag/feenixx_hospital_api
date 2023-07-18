<?php
class Paymentcalculation
{
	public function __construct(){
	    $this->CI =& get_instance();
	}

    function calculate_payment($appointment_id='')
    {

    	$total_charges = self::get_total_charges($appointment_id);
        $total_paid_amount = self::get_total_paid_amount($appointment_id);
        $remaining_amount = $total_charges - $total_paid_amount;
        $return_array['total_charges']=$total_charges; 
        $return_array['total_paid_amount']=$total_paid_amount; 
        $return_array['remaining_amount']=$remaining_amount;
        return $return_array;
    }


    function get_total_charges($appointment_id=''){
    	$charges_info = $this->CI->model->selectWhereData('tbl_charges',array('fk_appointment_id'=>$appointment_id),array('total_amount'),false);
        $chargesSum = array_sum(array_column($charges_info, 'total_amount'));
        return $chargesSum;
    }

    function get_total_paid_amount($appointment_id=''){
    	$charges_info = $this->CI->model->selectWhereData('tbl_payment_history',array('fk_appointment_id'=>$appointment_id),array('total_amount'),false);
        $totalPaidAmount = array_sum(array_column($charges_info, 'total_amount'));
        return $totalPaidAmount;
    }
}