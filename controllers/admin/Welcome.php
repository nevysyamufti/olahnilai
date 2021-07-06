<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Welcome extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
	}
	public function index()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/home');
		$this->load->view('admin/footer');
	}
}
 ?>