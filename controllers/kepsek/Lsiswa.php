<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lsiswa extends CI_Controller 
{

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("kepala_sekolah")) {
			redirect('','refresh');
		}

		$this->load->model('MKepsek');
		$this->load->model('MSiswa');
		// $this->load->model('MGuru');
		// $this->load->model('MRapor');
	}

	public function index()
	{
		 $data['siswa'] = $this->MSiswa->tampil();
		$this->load->view('kepsek/header');	
		$this->load->view('kepsek/dsiswa/lsiswa', $data);
		$this->load->view('kepsek/footer');
	}

	public function detail($id_siswa)
	{
		$data['detail'] = $this->MSiswa->detail($id_siswa);
		$this->load->view('kepsek/header');
		$this->load->view('kepsek/dsiswa/detail', $data);
		$this->load->view('kepsek/footer');		
	}

}

/* End of file Lsiswa.php */
/* Location: ./application/controllers/kepsek/Lsiswa.php */