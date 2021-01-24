<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();			
		$this->load->library('Commonfunction','','fn');
		
    }
		 
	public function index()
	{
		if(!isset($this->session->userdata['codeUser']))
		{
			$this->load->view('page_login');
		}
		else
		{
			redirect('admin', 'refresh');
			
		}
	}
	
	public function logon()
	{
		
		$username=$this->input->post("username");
		$password=$this->input->post("password");
		//$this->load->model('Mlogin');
		
		//check login
		$this->load->database();
		$this->load->model('Mmain');
		$userdata="";

		$tb=" admin 
			WHERE uname = ".$this->db->escape($username)."  AND pass ='".md5($password)."' ";
		$sel="";
		$query=$this->Mmain->qRead($tb,$sel,"");
		$loginSuccess=0;
		
		
		if($query->num_rows() > 0)
		{		    
			
			
			foreach($query->result() as $row)
			{
				
			$this->session->set_userdata(array(
				'name' => $row->uname,
				'codeUser' => $row->id_admin,
				'picUser' => $row->foto,
				'accUser' => $row->level
				
				
				));
				
			}
			//echo $currentDateTime;
			
			//change last login				
			//$this->Mmain->qUpdpart("tb_user",Array("code_user"),Array($userdata[1]),Array("isonline_user","lastlogin_user"),Array(1,$currentDateTime));
					
			$this->session->sess_expiration = '32140800'; //~ one year
			$this->session->sess_expire_on_close = 'false';
			
	
			redirect('admin', 'refresh');
		}
		else
		{
			//echo $this->input->post("password");
			$tes['errVar']=1;
			$this->load->view('page_login',$tes);
		}
	}
	
	
	
	public function logout()
	{
			session_destroy();
			redirect('main', 'refresh');
	}
}
