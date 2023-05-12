<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	
	public function register_email($user_email='', $email_id='', $password='', $name='')
    {
        if (!empty($email_id)) {
            $email_template_info = $this->model->selectWhereData('email_template', array('subject'=>'Login Credentials','status'=>'1'), array('subject','body'));
            $dynamic_data = array("{emailid}","{password}");
            $dynamic_value = array($user_email,$password);
            $email_data_post['email_txt']=str_replace($dynamic_data, $dynamic_value, $email_template_info['body']);
            $email_data_post['message']=$email_template_info['subject'];
            $email_data_post['name']=$name;
            send_email($email_id, $email_template_info['subject'], $email_data_post);
            return true;
        } else {
            return true;
        }
    }
}
?>