<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	public function display_all_doctor_details()
	{
		$this->db->select('tbl_users.*,tbl_user_type.user_type,CONCAT(tbl_users.login_status,",",tbl_users.id) AS statusdata');
		$this->db->from('tbl_users');
		$this->db->join('tbl_user_type','tbl_user_type.id=tbl_users.fk_user_type','left');
		$this->db->where('tbl_users.fk_user_type',2);
		$this->db->where('tbl_users.del_status',1);
		$this->db->order_by('tbl_users.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
}

