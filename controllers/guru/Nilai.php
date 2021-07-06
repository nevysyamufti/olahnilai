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
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		$this->load->model('MNilai');
		$this->load->model('MDetailguru');
		$this->load->model('MSiswa');
		$this->load->model('MSemester');
		$this->load->model('MSiswakelas');
		$this->load->model('MTahun');
	}

	public function index()
	{
		$session_guru = $this->session->userdata("guru");
		$data['kelas'] = $this->MDetailguru->tampil_kelas($session_guru['id_guru'], tahun_aktif());
		//$tahun_ajaran = $this->session->userdata('tahun_ajaran');
		//$data['detailguru'] = $this->MDetailguru->tampil_tahun_guru($guru['id_guru'], $tahun_ajaran['id_tahun_ajaran']);
		$data['semester'] = $this->MSemester->tampil();
		$data['semester_aktif'] = $this->MSemester->semester_aktif();
		$data['tahun_aktif'] = $this->MTahun->tahun_aktif();
		$get =  $this->input->get();
		if($get){
			$data['id_kelas'] = $get['id_kelas'];
			$data['id_mapel'] = $get['id_mapel'];
			$data['id_semester'] = $get['id_semester'];
			$data['mapel'] = $this->MDetailguru->tampil_mapel($session_guru['id_guru'], tahun_aktif(), $data['id_kelas']);
			$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $data['id_kelas']);
			// $data_semester = $this->MSemester->semester_aktif();

			$data_det_guru_mapel = $this->MDetailguru->cek(tahun_aktif(), $session_guru['id_guru'], $data['id_kelas'], $data['id_mapel']);

			$data['nilai'] = $this->MNilai->tampil_nilai($data_det_guru_mapel['id_det_guru_mapel'], $data['id_semester']);

			$inputan = $this->input->post();
			if ($inputan) {
				$this->MNilai->simpan($inputan, $data_det_guru_mapel['id_det_guru_mapel'], $data['id_semester']);
				redirect('guru/nilai?id_kelas='.$data["id_kelas"].'&id_mapel='.$data["id_mapel"].'&id_semester='.$data["id_semester"],'refresh');
			}
		}else{
			$data['id_kelas'] = "";
			$data['id_mapel'] = "";
			$data['id_semester'] = $data['semester_aktif']['id_semester'];
			$data['siswa'] = array();
		}
		$this->load->view('guru/header');
		$this->load->view('guru/nilai/tampil', $data);
		$this->load->view('guru/footer');
	}

	public function tambah()
	{


		$this->load->view('guru/header');
		$this->load->view('guru/nilai/tambah');
		$this->load->view('guru/footer');	
	}
}

?>