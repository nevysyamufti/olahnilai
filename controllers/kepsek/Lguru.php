<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lguru extends CI_Controller 
{

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("kepala_sekolah")) {
			redirect('','refresh');
		}

		$this->load->model('MKepsek');
		$this->load->model('MSiswa');
		$this->load->model('MGuru');
		// $this->load->model('MRapor');
	}

	public function index()
	{
		$data['guru'] = $this->MGuru->tampil();
		$this->load->view('kepsek/header');	
		$this->load->view('kepsek/dguru/lguru', $data);
		$this->load->view('kepsek/footer');
	}

	public function detail($id_guru)
	{
		$data['detail'] = $this->MGuru->detail($id_guru);
		$this->load->view('kepsek/header');
		$this->load->view('kepsek/dguru/detail', $data);
		$this->load->view('kepsek/footer');		
	}

}

/* End of file Lsiswa.php */
/* Location: ./application/controllers/kepsek/Lsiswa.php */