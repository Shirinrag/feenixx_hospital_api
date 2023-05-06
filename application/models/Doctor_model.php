<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Doctor_model extends CI_Model {
 
     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function _get_datatables_query()
    {    
        $column_order = array('first_name','last_name','email','contact','designation_name');
        $column_search = array('first_name','last_name','email','contact','designation_name');

        $this->db->select('tbl_doctor.*,tbl_states.name,CONCAT(tbl_doctor.status,",",tbl_doctor.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_designation.designation_name');
        $this->db->from('tbl_doctor');
        $this->db->join('tbl_states','tbl_states.id=tbl_doctor.state','left');
        $this->db->join('tbl_cities','tbl_cities.id=tbl_doctor.city','left');
        $this->db->join('tbl_gender','tbl_gender.id=tbl_doctor.fk_gender_id','left');
        $this->db->join('tbl_designation','tbl_designation.id=tbl_doctor.fk_designation_id','left');
        $this->db->where('tbl_doctor.del_status',1);
	    $this->db->order_by('tbl_doctor.id','DESC'); 
	       
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
       // if($_POST['length'] != -1)
       // $this->db->limit($_POST['length'],$_POST['start']);
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
        $this->db->select('tbl_doctor.*,tbl_states.name,CONCAT(tbl_doctor.status,",",tbl_doctor.id) AS statusdata,tbl_cities.city as city_name,tbl_gender.gender,tbl_designation.designation_name');
        $this->db->from('tbl_doctor');
        $this->db->join('tbl_states','tbl_states.id=tbl_doctor.state','left');
        $this->db->join('tbl_cities','tbl_cities.id=tbl_doctor.city','left');
        $this->db->join('tbl_gender','tbl_gender.id=tbl_doctor.fk_gender_id','left');
        $this->db->join('tbl_designation','tbl_designation.id=tbl_doctor.fk_designation_id','left');
        $this->db->where('tbl_doctor.del_status',1);
        $this->db->order_by('tbl_doctor.id','DESC'); 
        return $this->db->count_all_results();
    }
}