<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Staff_model extends CI_Model {
 
     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function _get_datatables_query()
    {    
        $column_order = array('first_name','last_name','email','contact','dob');
        $column_search = array('first_name','last_name','email','contact','dob');

        $this->db->select('tbl_staff.*,tbl_states.name,CONCAT(tbl_staff.status,",",tbl_staff.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_user_type.user_type,tbl_users.fk_user_type');
        $this->db->from('tbl_staff');
        $this->db->join('tbl_states','tbl_states.id=tbl_staff.fk_state_id','left');
        $this->db->join('tbl_cities','tbl_cities.id=tbl_staff.fk_city_id','left');
        $this->db->join('tbl_gender','tbl_gender.id=tbl_staff.fk_gender_id','left');
        $this->db->join('tbl_users','tbl_users.fk_id=tbl_staff.id','left');
        $this->db->join('tbl_user_type','tbl_user_type.id=tbl_users.fk_user_type','left');
        $this->db->where('tbl_staff.del_status',1);
        $this->db->where('tbl_users.fk_user_type !=',1);
        $this->db->where('tbl_users.fk_user_type !=',2);
        $this->db->where('tbl_users.fk_user_type !=',4);
	    $this->db->order_by('tbl_staff.id','DESC'); 
	       
        $i = 0; 

        foreach ($column_search as $item) // loop column 
        {
            if(@$_POST['search']['value']) // if datatable send POST for search
            {                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, @$_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, @$_POST['search']['value']);
                } 

                if(count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket
            }

            $i++;
        }     

        if(!empty(@$_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[@$_POST['order']['0']['column']], @$_POST['order']['0']['dir']);
        } 

        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        $query=$this->db->get();
        return $query->result_array();
    } 

    function count_filtered()
    {
        $this->_get_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();
    } 

    public function count_all()
    {         
        $this->db->select('tbl_staff.*,tbl_states.name,CONCAT(tbl_staff.status,",",tbl_staff.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_user_type.user_type,tbl_users.fk_user_type');
        $this->db->from('tbl_staff');
        $this->db->join('tbl_states','tbl_states.id=tbl_staff.fk_state_id','left');
        $this->db->join('tbl_cities','tbl_cities.id=tbl_staff.fk_city_id','left');
        $this->db->join('tbl_gender','tbl_gender.id=tbl_staff.fk_gender_id','left');
        $this->db->join('tbl_users','tbl_users.fk_id=tbl_staff.id','left');

        $this->db->join('tbl_user_type','tbl_user_type.id=tbl_users.fk_user_type','left');
        $this->db->where('tbl_staff.del_status',1);
         $this->db->where('tbl_users.fk_user_type !=',1);
        $this->db->where('tbl_users.fk_user_type !=',2);
        $this->db->where('tbl_users.fk_user_type !=',4);
        $this->db->order_by('tbl_staff.id','DESC'); 
        return $this->db->count_all_results();
    }
}