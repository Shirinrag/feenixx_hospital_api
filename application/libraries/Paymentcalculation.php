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
        $discount_amount = $this->CI->model->selectWhereData('tbl_appointment',array('id'=>$appointment_id),array('discount_amount'));
        if(empty($discount_amount['discount_amount'])){
            $discount_amount_1 = 0;
        }else{
            $discount_amount_1 = $discount_amount['discount_amount'];
        }

        $total_charges_1 = $total_charges - $discount_amount_1;
        $remaining_amount = $total_charges_1 - $total_paid_amount;
        $return_array['total_charges']=$total_charges_1; 
        $return_array['total_paid_amount']=$total_paid_amount; 
        $return_array['remaining_amount']=$remaining_amount;
        return $return_array;
    }
    function get_total_charges($appointment_id=''){
    	$charges_info = $this->CI->model->selectWhereData('tbl_charges',array('fk_appointment_id'=>$appointment_id),array('total_amount'),false);
        if(!empty($charges_info)){
            $charges_info_1 = array_sum(array_column(@$charges_info, 'total_amount'));
        }else{
            $charges_info_1 = 0;
        }
        $chargesSum = $charges_info_1;
        return @$chargesSum;
    }

    function get_total_paid_amount($appointment_id=''){
    	$charges_info = $this->CI->model->selectWhereData('tbl_payment_history',array('fk_appointment_id'=> @$appointment_id),array('total_amount'),false);
        if(!empty($charges_info)){
            $charges_info_1 = array_sum(array_column(@$charges_info, 'total_amount'));
        }else{
            $charges_info_1 = 0;
        }
        $totalPaidAmount = $charges_info_1;
        return @$totalPaidAmount;
    }
}