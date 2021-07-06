<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rapor extends CI_Controller {

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
	}

	public function index()
	{
		$guru = $this->session->userdata("guru");
		$tampil_kelas = $this->MWalikelas->tampil_kelas(tahun_aktif(), $guru['id_guru']);
		$data['semester'] = $this->MSemester->tampil();
		$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $tampil_kelas['id_kelas']);
		$this->load->view('guru/header');
		$this->load->view('guru/rapor/tampil', $data);
		$this->load->view('guru/footer');
	}

	public function detail($id_siswa_kelas, $id_semester)
	{
		$session_siswa = $this->MSiswakelas->detail($id_siswa_kelas);
		$data['id_semester'] = $id_semester;

		$data['semester'] = $this->MSemester->tampil();

		$data['siswa'] = $session_siswa;
		$data['siswa_tahun'] = $this->MSiswakelas->siswa_tahun($session_siswa['id_siswa'], tahun_aktif());

		$data['semester_aktif'] = $this->MSemester->detail($data['id_semester']);
		$data['tahun_aktif'] = $this->session->userdata('tahun_ajaran');
		$data['nilai_sikap'] = $this->MSikap->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		$data['wali_kelas'] = $this->MWalikelas->tampil_rapor(tahun_aktif(), $data['siswa_tahun']['id_kelas']);

		$data['nilai_pengetahuan'] = $this->MNilai->siswa_nilai_kelompok(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		$data['nilai_ekstra'] = $this->MNilaiekstra->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		$data['absensi'] = $this->MAbsensi->tampil_rapor(tahun_aktif(), $session_siswa['id_siswa'], $data['id_semester']);

		//gunakan substr untuk memotong string, string awal 10 IPA. dipotong dr data ke 0 sampai data 2 keambil 10.
		$kelas_sekarang = substr($data['siswa_tahun']['nama_kelas'], 0,2);
		if ($data['semester_aktif']['nama_semester']=='Semester Ganjil') {
			if ($kelas_sekarang==10) {
				$data['keputusan'] = "Lanjut ke semester genap kelas X (Sepuluh)";
			} elseif ($kelas_sekarang==11){
				$data['keputusan'] = "Lanjut ke semester genap kelas XI (Sebelas)";
			} elseif ($kelas_sekarang==12){
				$data['keputusan'] = "Lanjut ke semester genap kelas XII (Dua belas)";
			}
		} elseif ($data['semester_aktif']['nama_semester']=='Semester Genap'){
			if ($kelas_sekarang==10) {
				$data['keputusan'] = "Naik kelas XI (Sebelas)";
			} elseif ($kelas_sekarang==11){
				$data['keputusan'] = "Naik kelas XII(Dua belas)";
			} elseif ($kelas_sekarang==12){
				$data['keputusan'] = "LULUS";
			}
		}

		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_akhir(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		
		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('guru/header');
		$this->load->view('guru/rapor/rapor', $data);
		$this->load->view('guru/footer');
	}

	public function cetak($id_siswa_kelas, $id_semester)
	{
		$session_siswa = $this->MSiswakelas->detail($id_siswa_kelas);
		$data['id_semester'] = $id_semester;
		$data['siswa'] = $session_siswa;
		$data['siswa_tahun'] = $this->MSiswakelas->siswa_tahun($session_siswa['id_siswa'], tahun_aktif());
		$data['semester_aktif'] = $this->MSemester->detail($data['id_semester']);
		$data['tahun_aktif'] = $this->session->userdata('tahun_ajaran');
		$data['nilai_sikap'] = $this->MSikap->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		$data['wali_kelas'] = $this->MWalikelas->tampil_rapor(tahun_aktif(), $data['siswa_tahun']['id_kelas']);

		$data['nilai_pengetahuan'] = $this->MNilai->siswa_nilai_kelompok(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		$data['nilai_ekstra'] = $this->MNilaiekstra->tampil_rapor($data['siswa_tahun']['id_siswa_kelas'], $data['id_semester']);
		$data['absensi'] = $this->MAbsensi->tampil_rapor(tahun_aktif(), $session_siswa['id_siswa'], $data['id_semester']);

		// $data['tahun'] = $this->MTahun->detail(tahun_aktif());

		$kelas_sekarang = substr($data['siswa_tahun']['nama_kelas'], 0,2);
		if ($data['semester_aktif']['nama_semester']=='Semester Ganjil') {
			if ($kelas_sekarang==10) {
				$data['keputusan'] = "Lanjut ke semester genap kelas X (Sepuluh)";
			} elseif ($kelas_sekarang==11){
				$data['keputusan'] = "Lanjut ke semester genap kelas XI (Sebelas)";
			} elseif ($kelas_sekarang==12){
				$data['keputusan'] = "Lanjut ke semester genap kelas XII (Dua belas)";
			}
		} elseif ($data['semester_aktif']['nama_semester']=='Semester Genap'){
			if ($kelas_sekarang==10) {
				$data['keputusan'] = "Naik kelas XI (Sebelas)";
			} elseif ($kelas_sekarang==11){
				$data['keputusan'] = "Naik kelas XII(Dua belas)";
			} elseif ($kelas_sekarang==12){
				$data['keputusan'] = "LULUS";
			}
		}
		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_akhir(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		
		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('guru/header');
		$this->load->view('guru/rapor/cetak', $data);
		$this->load->view('guru/footer');
	}
}

/* End of file Rapor.php */
/* Location: ./application/controllers/siswa/Rapor.php */