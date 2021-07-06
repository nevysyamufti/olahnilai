<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Absensi extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("ortu")) {
			redirect('','refresh');
		}

		$this->load->model('MAbsensi');
		$this->load->model('MSemester');
	}

	public function index()
	{
		$session_ortu = $this->session->userdata('ortu');
		$get = $this->input->get();
		if($get){
			$data['id_semester'] = $get['id_semester'];
		}else{
			$semester_aktif = $this->MSemester->semester_aktif();
			$data['id_semester'] = $semester_aktif['id_semester'];
		}
		$data['semester'] = $this->MSemester->tampil();
		$data['absensi'] =  $this->MAbsensi->siswa_absensi(tahun_aktif(), $data['id_semester'], $session_ortu['id_siswa']);
		$data['akumulasi'] = $this->MAbsensi->akumulasi_absensi(tahun_aktif(), $session_ortu['id_siswa'], $data['id_semester']);
		// echo '<pre>';
		// print_r($data['absensi']); 
		// echo '</pre>';

		$this->load->view('ortu/header');
		$this->load->view('ortu/absensi/tampil', $data);
		$this->load->view('ortu/footer');
	}  
}