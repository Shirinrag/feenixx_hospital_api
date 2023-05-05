<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function display_all_doctor_details()
	{
		$this->db->select('tbl_doctor.*,tbl_state.name,CONCAT(tbl_doctor.status,",",tbl_doctor.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_designation.designation_name');
		$this->db->from('tbl_doctor');
		$this->db->join('tbl_state','tbl_state.id=tbl_doctor.state','left');
		$this->db->join('tbl_cities','tbl_cities.id=tbl_doctor.city','left');
		$this->db->join('tbl_gender','tbl_gender.id=tbl_doctor.fk_gender_id','left');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_doctor.fk_designation_id','left');
		$this->db->where('tbl_doctor.del_status',1);
		$this->db->order_by('tbl_doctor.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
}

