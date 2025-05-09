<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('auth_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		if(isset($_SESSION['user_name']) != null){
			redirect('Dashboard/Admin', 'refresh');
		}else{
			$this->load->view('Pages/login');
		}
	}

	private function check_auth(){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}
	}

	public function processlogin(){
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		
		$login = $this->auth_model->get_login_data($username, $password);
		if($login != null){
			$user_name = $login[0]->user_name;
			$user_id  = $login[0]->user_id ;
			$user_role  = $login[0]->user_role ;

			$role_access 		= $this->auth_model->get_nav_auth($user_role);
			$role_access_header = $this->auth_model->get_nav_auth_header($user_role);

			$newdata = [
				'user_name' 			=> $user_name,
				'user_id'   			=> $user_id,
				'user_role' 			=> $user_role,
				'logged_in' 			=> TRUE,
				'role_access' 			=> $role_access,
				'role_access_header' 	=> $role_access_header
			];
			$this->session->set_userdata($newdata);
			$msg = 'Sukses login';
			echo json_encode(['code'=>'200', 'msg'=>$msg]); 
		}else{
			$msg = 'Username Atau Password Salah';
			echo json_encode(['code'=>0, 'msg'=>$msg]);
		}	
	}

	public function processlogout(){
		$this->session->sess_destroy();
		redirect('Auth', 'refresh');
	}

	public function changepass()
	{
		$this->check_auth();
		$this->load->view('Pages/changepass');
	}

	public function change_pass()
	{
		$this->check_auth();
		$id  	= $_SESSION['user_id'];
		$old_pass = md5($this->input->post('old_pass'));
		$new_pass = md5($this->input->post('new_pass'));

		$check_data = $this->auth_model->check_data($old_pass, $id);
		if($check_data == null){
			$msg = 'Password Lama Salah';
			echo json_encode(['code'=>0, 'msg'=>$msg]);die();
		}else{
			$update_pass = array(
				'user_password'	       => $new_pass,
			);

			$this->auth_model->update_pass($update_pass, $id);
			$msg = 'Sukses Update Pasword';
			echo json_encode(['code'=>200, 'msg'=>$msg]);die();
		}

	}

}

?>