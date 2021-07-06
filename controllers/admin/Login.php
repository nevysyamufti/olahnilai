<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		//$this->load->model('MLogin');
	}

	public function index()
	{
		//$data['login'] = $this->MLogin->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/login/tampil');
		$this->load->view('admin/footer');
	}
}


/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */
 ?>