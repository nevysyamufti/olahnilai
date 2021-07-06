<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("siswa")) {
			redirect('','refresh');
		}
		$this->load->model('MNilai');
		// $this->load->model('MAbsensi');
		// $this->load->model('MSemester');		
	}
	public function index()
	{
		$session_siswa = $this->session->userdata('siswa');
		$data['nilai'] = $this->MNilai->grafik($session_siswa['id_siswa']);
		$this->load->view('siswa/header');
		$this->load->view('siswa/nilai/grafik', $data);
		$this->load->view('siswa/footer');
	}


}

/* End of file Grafik.php */
/* Location: ./application/controllers/siswa/Grafik.php */