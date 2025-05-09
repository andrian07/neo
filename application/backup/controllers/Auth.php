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

			$newdata = [
				'user_name'  => $user_name,
				'user_id' => $user_id,
				'user_role' => $user_role,
				'logged_in' => TRUE,
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

}

?>