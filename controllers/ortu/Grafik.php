<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("ortu")) {
			redirect('','refresh');
		}
		$this->load->model('MNilai');
		// $this->load->model('MAbsensi');
		// $this->load->model('MSemester');		
	}
	public function index()
	{
		$session_ortu = $this->session->userdata('ortu');
		$data['nilai'] = $this->MNilai->grafik($session_ortu['id_siswa']);
		$this->load->view('ortu/header');
		$this->load->view('ortu/nilai/grafik', $data);
		$this->load->view('ortu/footer');
	}


}

/* End of file Grafik.php */
/* Location: ./application/controllers/siswa/Grafik.php */