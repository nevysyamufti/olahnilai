<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Nilai extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("siswa")) {
			redirect('','refresh');
		}

		$this->load->model('MNilai');
		$this->load->model('MSemester');
		$this->load->model('MTahun'); 
	}

	public function index()
	{
		$session_siswa = $this->session->userdata('siswa');
		$get = $this->input->get();
		if($get){
			$data['id_semester'] = $get['id_semester'];
		}else{
			$semester_aktif = $this->MSemester->semester_aktif();
			$data['id_semester'] = $semester_aktif['id_semester'];
		}
		$data['semester'] = $this->MSemester->tampil();
		$data['nilai'] =  $this->MNilai->siswa_nilai(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_akhir(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		// echo '<pre>';
		// print_r($data['nilai']); 
		// echo '</pre>';

		$this->load->view('siswa/header');
		$this->load->view('siswa/nilai/tampil', $data);
		$this->load->view('siswa/footer');
	}  
}


/* End of file Nilai.php */
/* Location: ./application/controllers/siswa/Nilai.php */
 ?>