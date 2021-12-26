<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('username')) {
			// do something when exist
			redirect('home/index');
		} else {
			// do something when doesn't exist
			$this->load->view('login');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('username');
		redirect('login/index');
	}

	public function masuk()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ($username == "TeknikSipil" && $password == "admin") {
			$this->session->set_userdata('username', $username);
			redirect('home/index');
		} else {
			redirect('login/index');
		}
	}
}

?>