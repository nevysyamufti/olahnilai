<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detailnilai extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("ortu")) {
			redirect('','refresh');
		}

		$this->load->model('MNilai');
		// $this->load->model('MSemester');
		// $this->load->model('MTahun'); 
		// $this->load->model('MMapel');
	}

	public function index()
	{
		$data=array();
		 $session_ortu = $this->session->userdata('ortu');
		// $data['detnil'] = $this->MNilai->detail_nilai($session_siswa['$id_siswa']);
		// echo "<pre>";
		// print_r ($data);
		// echo "</pre>";
		// $get = $this->input->get();
		// if($get){
		// }else{
		// 	$semester_aktif = $this->MSemester->semester_aktif();
		// 	$data['id_semester'] = $semester_aktif['id_semester'];
		// }

		// $data['semester'] = $this->MSemester->tampil();
		$data['detni'] =  $this->MNilai->semua_siswa_nilai( $session_ortu['id_siswa']);
		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_semua($session_ortu['id_siswa']);

		// echo '<pre>';
		// print_r($data['nilai']); 
		// echo '</pre>';

		$this->load->view('ortu/header');
		$this->load->view('ortu/nilai/detailnilai', $data);
		$this->load->view('ortu/footer');
	}  

}

/* End of file Detail_nilai.php */
/* Location: ./application/controllers/siswa/Detail_nilai.php */