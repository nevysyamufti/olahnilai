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
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
	}
	public function index()
	{
		$this->load->view('guru/header');
		$this->load->view('guru/home');
		$this->load->view('guru/footer');
	}

	public function ubah_session_tahun_ajaran()
	{
		$inputan= $this->input->post();
		$id_tahun_ajaran = $inputan['id_tahun_ajaran'];
		$this->load->model('MTahun');
		$data_tahun_ajaran = $this->MTahun->detail($id_tahun_ajaran);
		$this->session->set_userdata("tahun_ajaran", $data_tahun_ajaran);
		redirect($_SERVER['HTTP_REFERER'],'refresh');
	}
}
 ?>