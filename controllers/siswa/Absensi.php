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
		if (!$this->session->userdata("siswa")) {
			redirect('','refresh');
		}

		$this->load->model('MAbsensi');
		$this->load->model('MSemester');
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
		$data['absensi'] =  $this->MAbsensi->siswa_absensi(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		$data['akumulasi'] = $this->MAbsensi->akumulasi_absensi(tahun_aktif(), $session_siswa['id_siswa'], $data['id_semester']);
		// echo '<pre>';
		// print_r($data['absensi']); 
		// echo '</pre>';

		$this->load->view('siswa/header');
		$this->load->view('siswa/absensi/tampil', $data);
		$this->load->view('siswa/footer');
	}  
}