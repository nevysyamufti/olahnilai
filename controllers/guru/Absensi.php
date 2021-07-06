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
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		$this->load->model('MWalikelas');
		$this->load->model('MSiswakelas');
		$this->load->model('MSemester');
		$this->load->model('MAbsensi');
	}

	public function index()
	{
		$guru = $this->session->userdata('guru');
		$tampil_kelas = $this->MWalikelas->tampil_kelas(tahun_aktif(), $guru['id_guru']);
		$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $tampil_kelas['id_kelas']);
		//untuk mengotomatiskan semester yang aktif
		$data_semester = $this->MSemester->semester_aktif();
		//mengambil data dari url (data url berasal dari tanggal yang dipilih)
		$get = $this->input->get();
		//jika ada data dari utl maka
		if($get){
			//tanggal absensi mengambil dari url
			$data['tanggal_absensi'] = $get['tanggal_absensi'];
		}else{
			//selain itu maka tanggal sekarang
			$data['tanggal_absensi'] = date("Y-m-d");
		}
		//untuk menampilkan apa yang disimpan
		$data['absensi'] = $this->MAbsensi->tampil($data['tanggal_absensi']);

		$inputan = $this->input->post();
		if ($inputan) {
			$this->MAbsensi->simpan($data_semester['id_semester'], $data['tanggal_absensi'], $inputan);
			redirect('guru/absensi','refresh');
		}

		$this->load->view('guru/header');
		$this->load->view('guru/Absensi/tampil', $data);
		$this->load->view('guru/footer');
	}
}

/* End of file Absensi.php */
/* Location: ./application/controllers/guru/Absensi.php */
?>