<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function display_all_doctor_details()
	{
		$this->db->select('tbl_doctor.*,tbl_states.name,CONCAT(tbl_doctor.status,",",tbl_doctor.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_designation.designation_name');
		$this->db->from('tbl_doctor');
		$this->db->join('tbl_states','tbl_states.id=tbl_doctor.state','left');
		$this->db->join('tbl_cities','tbl_cities.id=tbl_doctor.city','left');
		$this->db->join('tbl_gender','tbl_gender.id=tbl_doctor.fk_gender_id','left');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_doctor.fk_designation_id','left');
		$this->db->where('tbl_doctor.del_status',1);
		$this->db->order_by('tbl_doctor.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function get_patient_details_on_patient_id($id='')
	{
		$this->db->select('tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.email,tbl_patients.contact_no,tbl_gender.gender,tbl_blood_group.blood_group');
		$this->db->from('tbl_patients');
		$this->db->join('tbl_gender','tbl_gender.id=tbl_patients.fk_gender_id','left');
		$this->db->join('tbl_blood_group','tbl_blood_group.id=tbl_patients.fk_blood_group_id','left');
		$this->db->where('tbl_patients.id',$id);
		$query = $this->db->get();
        $result = $query->row_array();
        return $result;
	}
	public function get_all_appointment_details()
	{
		$this->db->select('tbl_appointment.*,tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.email,tbl_patients.contact_no,tbl_doctor.first_name as doctor_first_name,tbl_doctor.last_name as doctor_last_name,tbl_blood_group.blood_group,tbl_diseases.diseases_name,tbl_gender.gender,tbl_appointment_type.type,tbl_appointment_sub_type.sub_type,tbl_payment.grand_total');
		// tbl_payment_history.fk_payment_id,
		$this->db->from('tbl_appointment');
		$this->db->join('tbl_patients','tbl_patients.id=tbl_appointment.fk_patient_id','left');
		$this->db->join('tbl_doctor','tbl_doctor.id=tbl_appointment.fk_doctor_id','left');
		$this->db->join('tbl_payment','tbl_payment.fk_appointment_id=tbl_appointment.id','left');
		// $this->db->join('tbl_payment_history','tbl_payment_history.fk_payment_id=tbl_payment.id','left');
		$this->db->join('tbl_blood_group','tbl_patients.fk_blood_group_id=tbl_blood_group.id','left');
		$this->db->join('tbl_diseases','tbl_appointment.fk_diseases_id=tbl_diseases.id','left');		
		$this->db->join('tbl_gender','tbl_patients.fk_gender_id=tbl_gender.id','left');	
		$this->db->join('tbl_appointment_type','tbl_appointment.admission_type=tbl_appointment_type.id','left');
		$this->db->join('tbl_appointment_sub_type','tbl_appointment.fk_admission_sub_type_id=tbl_appointment_sub_type.id','left');	
		$this->db->order_by('tbl_appointment.id','DESC');
		$this->db->group_by('tbl_appointment.id');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function display_all_diesases_details()
	{
		$this->db->select('tbl_diseases.*,CONCAT(tbl_diseases.status,",",tbl_diseases.id) AS statusdata');
		$this->db->from('tbl_diseases');
		$this->db->where('del_status',1);
		$this->db->order_by('tbl_diseases.id','DESC');
		$this->db->group_by('tbl_diseases.id');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function get_all_staff_on_id($id='')
	{
		$this->db->select('tbl_staff.*,tbl_user_type.user_type,tbl_users.fk_user_type');
        $this->db->from('tbl_staff');       
        $this->db->join('tbl_users','tbl_users.fk_id=tbl_staff.id','left');
        $this->db->join('tbl_user_type','tbl_user_type.id=tbl_users.fk_user_type','left');
        $this->db->where('tbl_staff.id',$id);
        $this->db->where('tbl_users.fk_user_type !=',1);
        $this->db->where('tbl_users.fk_user_type !=',2);
        $this->db->where('tbl_users.fk_user_type !=',4);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
	}
	public function get_all_appointment_details_doctor($id="")
	{
		$this->db->select('tbl_appointment.*,tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.email,tbl_patients.contact_no,tbl_doctor.first_name as doctor_first_name,tbl_doctor.last_name as doctor_last_name,tbl_payment.grand_total,tbl_blood_group.blood_group,tbl_diseases.diseases_name,tbl_gender.gender');
		$this->db->from('tbl_appointment');
		$this->db->join('tbl_patients','tbl_patients.id=tbl_appointment.fk_patient_id','left');
		$this->db->join('tbl_doctor','tbl_doctor.id=tbl_appointment.fk_doctor_id','left');
		$this->db->join('tbl_payment','tbl_payment.fk_appointment_id=tbl_appointment.id','left');
		$this->db->join('tbl_blood_group','tbl_patients.fk_blood_group_id=tbl_blood_group.id','left');
		$this->db->join('tbl_diseases','tbl_appointment.fk_diseases_id=tbl_diseases.id','left');		
		$this->db->join('tbl_gender','tbl_patients.fk_gender_id=tbl_gender.id','left');		
		$this->db->where('tbl_appointment.fk_doctor_id',$id);
		$this->db->order_by('tbl_appointment.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function get_all_location_details()
	{
		$this->db->select('tbl_visit_location.*,tbl_states.name,CONCAT(tbl_visit_location.status,",",tbl_visit_location.id) AS statusdata,tbl_cities.city as city_name');
        $this->db->from('tbl_visit_location');
        $this->db->join('tbl_states','tbl_states.id=tbl_visit_location.fk_state_id','left');
        $this->db->join('tbl_cities','tbl_cities.id=tbl_visit_location.fk_city_id','left');
        $this->db->where('tbl_visit_location.del_status',1);
        $this->db->order_by('tbl_visit_location.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function display_all_charges_details()
	{
		$this->db->select('tbl_charges_type.*,CONCAT(tbl_charges_type.status,",",tbl_charges_type.id) AS statusdata');
		$this->db->from('tbl_charges_type');
		$this->db->where('del_status',1);
		$this->db->order_by('tbl_charges_type.id','DESC');
		$this->db->group_by('tbl_charges_type.id');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	public function get_payment_data_on_appointment_id($id='')
	{
		$this->db->select('tbl_appointment.*,tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.email,tbl_patients.contact_no,tbl_doctor.first_name as doctor_first_name,tbl_doctor.last_name as doctor_last_name,tbl_blood_group.blood_group,tbl_diseases.diseases_name,tbl_gender.gender,tbl_payment.id as payment_id,tbl_appointment_type.type,tbl_appointment_sub_type.sub_type');
		$this->db->from('tbl_appointment');
		$this->db->join('tbl_patients','tbl_patients.id=tbl_appointment.fk_patient_id','left');
		$this->db->join('tbl_doctor','tbl_doctor.id=tbl_appointment.fk_doctor_id','left');
		$this->db->join('tbl_payment','tbl_payment.fk_appointment_id=tbl_appointment.id','left');
		$this->db->join('tbl_blood_group','tbl_patients.fk_blood_group_id=tbl_blood_group.id','left');
		$this->db->join('tbl_diseases','tbl_appointment.fk_diseases_id=tbl_diseases.id','left');		
		$this->db->join('tbl_gender','tbl_patients.fk_gender_id=tbl_gender.id','left');	
		$this->db->join('tbl_appointment_type','tbl_appointment.admission_type=tbl_appointment_type.id','left');	
		$this->db->join('tbl_appointment_sub_type','tbl_appointment.fk_admission_sub_type_id=tbl_appointment_sub_type.id','left');	
		$this->db->where('tbl_appointment.id',$id);
		$query = $this->db->get();
        $result = $query->row_array();
        return $result;
	}
	public function get_last_invoice_no()
	{
		$this->db->select('invoice_no');
        $this->db->from('tbl_invoice_no');
        $this->db->like('invoice_no', "FXH");
        $this->db->order_by('id',"DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
	}
	public function s_get_all_appointment_details()
	{
		$this->db->select('tbl_appointment.appointment_date,tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.email,tbl_patients.contact_no,tbl_doctor.first_name as doctor_first_name,tbl_doctor.last_name as doctor_last_name,GROUP_CONCAT(tbl_payment_history.amount) as amount,GROUP_CONCAT(tbl_payment_history.mediclaim_amount) as mediclaim_amount,GROUP_CONCAT(tbl_payment_history.total_amount) as total_amount,GROUP_CONCAT(tbl_payment_history.date) as date,tbl_gender.gender');
		$this->db->from('tbl_appointment');
		$this->db->join('tbl_patients','tbl_patients.id=tbl_appointment.fk_patient_id','left');
		$this->db->join('tbl_doctor','tbl_doctor.id=tbl_appointment.fk_doctor_id','left');
		// $this->db->join('tbl_payment','tbl_payment.fk_appointment_id=tbl_appointment.id','left');
		$this->db->join('tbl_payment_history','tbl_payment_history.fk_appointment_id=tbl_appointment.id','left');
		$this->db->join('tbl_gender','tbl_patients.fk_gender_id=tbl_gender.id','left');	
		$this->db->order_by('tbl_appointment.id','DESC');
		$this->db->group_by('tbl_appointment.id');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}

	public function get_all_advance_payment_details_on_appointment_id($id='')
	{
		$this->db->select('tbl_payment_history.*,tbl_payment_type.payment_type');
		$this->db->from('tbl_payment_history');
		$this->db->join('tbl_payment_type','tbl_payment_type.id=tbl_payment_history.fk_payment_id','left');
		$this->db->where('tbl_payment_history.fk_appointment_id',$id);
		$this->db->where('tbl_payment_history.is_advance',1);
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}

	public function get_all_final_payment_details_on_appointment_id($id='')
	{
		$this->db->select('tbl_payment_history.*,tbl_payment_type.payment_type');
		$this->db->from('tbl_payment_history');
		$this->db->join('tbl_payment_type','tbl_payment_type.id=tbl_payment_history.fk_payment_id','left');
		$this->db->where('tbl_payment_history.fk_appointment_id',$id);
		$this->db->where('tbl_payment_history.is_advance',2);
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}

	public function get_all_charges_payment_details_on_appointment_id($id='')
	{
		$this->db->select('tbl_charges.*,tbl_charges_type.charges_name');
		$this->db->from('tbl_charges');
		$this->db->join('tbl_charges_type','tbl_charges.fk_charges_type_id=tbl_charges_type.id','left');
		$this->db->where('tbl_charges.fk_appointment_id',$id);
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;

	}
	public function get_advanced_payment_data($id='')
	{
		$this->db->select('tbl_payment_history.*,tbl_payment_type.payment_type,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.patient_id');
		$this->db->from('tbl_payment_history');
		$this->db->join('tbl_payment_type','tbl_payment_type.id=tbl_payment_history.fk_payment_id','left');
		$this->db->join('tbl_patients','tbl_payment_history.fk_patient_id=tbl_patients.id','left');
		$this->db->where('tbl_payment_history.id',$id);
		$query = $this->db->get();
        $result = $query->row_array();
        return $result;
	}


	public function discharge_summary_details($id='')
	{
		$this->db->select('tbl_appointment.appointment_date,tbl_patients.patient_id,tbl_patients.first_name,tbl_patients.last_name,tbl_appointment.date_of_discharge,tbl_appointment.discharge_summary,tbl_doctor.first_name as doctor_first_name,tbl_doctor.last_name as doctor_last_name');
		$this->db->from('tbl_appointment');
		$this->db->join('tbl_patients','tbl_patients.id=tbl_appointment.fk_patient_id','left');
		$this->db->join('tbl_doctor','tbl_doctor.id=tbl_appointment.fk_doctor_id','left');
		$this->db->where('tbl_appointment.id',$id);
		$query = $this->db->get();
        $result = $query->row_array();
        return $result;
	}

	public function get_final_invoice_details($fk_appointment_id="",$fk_patient_id='')
	{
		$this->db->select('GROUP_CONCAT(tbl_charges.amount) AS charges_amount,GROUP_CONCAT(tbl_charges.no_of_count) AS charges_count,tbl_charges.date,tbl_charges_type.charges_name,tbl_patients.first_name,tbl_patients.last_name,tbl_patients.patient_id');
		$this->db->from('tbl_charges');
		$this->db->join('tbl_charges_type','tbl_charges.fk_charges_type_id=tbl_charges_type.id','left');
		$this->db->join('tbl_patients','tbl_charges.fk_patient_id=tbl_patients.id','left');
		$this->db->where('tbl_charges.fk_appointment_id',$fk_appointment_id);
		$this->db->group_by('tbl_charges.fk_charges_type_id');
		// $this->db->where('tbl_charges.fk_patient_id',$fk_patient_id);
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}


}

