<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dsiswa extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		$this->load->model('MNilai');
		$this->load->model('MSemester');
		$this->load->model('MSiswakelas');		
		$this->load->model('MSikap');
		$this->load->model('MWalikelas');
		$this->load->model('MNilaiekstra');
		$this->load->model('MKepsek');
		$this->load->model('MAbsensi');
		$this->load->model('MTahun');
	}

	public function index()
	{
		$guru = $this->session->userdata("guru");
		$tampil_kelas = $this->MWalikelas->tampil_kelas(tahun_aktif(), $guru['id_guru']);
		$data['semester'] = $this->MSemester->tampil();
		$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $tampil_kelas['id_kelas']);

		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('guru/header');
		$this->load->view('guru/dsiswa/tampil', $data);
		$this->load->view('guru/footer');
	}

	public function detail($id_siswa_kelas)
	{
		$session_siswa = $this->MSiswakelas->detail($id_siswa_kelas);
		// $data['id_semester'] = $id_semester;

		$data['semester'] = $this->MSemester->tampil();

		$data['siswa'] = $session_siswa;
		$data['siswa_tahun'] = $this->MSiswakelas->siswa_tahun($session_siswa['id_siswa'], tahun_aktif());

		// $data['semester_aktif'] = $this->MSemester->detail($data['id_semester']);
		$data['tahun_aktif'] = $this->session->userdata('tahun_ajaran');
		// $data['nilai_sikap'] = $this->MSikap->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		// $data['wali_kelas'] = $this->MWalikelas->tampil_rapor(tahun_aktif(), $data['siswa_tahun']['id_kelas']);

		// $data['nilai_pengetahuan'] = $this->MNilai->siswa_nilai(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		// $data['nilai_ekstra'] = $this->MNilaiekstra->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		// $data['absensi'] = $this->MAbsensi->tampil_rapor(tahun_aktif(), $session_siswa['id_siswa'], $data['id_semester']);
		
		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('guru/header');
		$this->load->view('guru/dsiswa/detail', $data);
		$this->load->view('guru/footer');
	}

	public function cetak($id_siswa_kelas)
	{
		$session_siswa = $this->MSiswakelas->detail($id_siswa_kelas);
		$data['siswa'] = $session_siswa;
		// $data['siswa'] = $this->session->userdata('siswa');
		$data['tahun'] = $this->MTahun->detail(tahun_aktif());
		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('guru/dsiswa/cetak', $data);
	}
}