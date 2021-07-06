<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rapor extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("siswa")) {
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
		$session_siswa = $this->session->userdata('siswa');
		$get = $this->input->get();
		if ($get) {
			$data['id_semester'] = $get['id_semester'];
		}else{
			$semester_aktif = $this->MSemester->semester_aktif();
			$data['id_semester'] = $semester_aktif['id_semester'];
		}
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
				$data['keputusan'] = "Naik / Tidak Naik kelas XI (Sebelas)";
			} elseif ($kelas_sekarang==11){
				$data['keputusan'] = "Naik / Tidak Naik kelas XII(Dua belas)";
			} elseif ($kelas_sekarang==12){
				$data['keputusan'] = "LULUS / Tidak Lulus";
			}
		}

		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_akhir(tahun_aktif(), $data['id_semester'], $session_siswa['id_siswa']);
		
		$data['kepala_sekolah'] = $this->MKepsek->tampil_aktif();
		$this->load->view('siswa/header');
		$this->load->view('siswa/rapor/rapor', $data);
		$this->load->view('siswa/footer');
	}
}

/* End of file Rapor.php */
/* Location: ./application/controllers/siswa/Rapor.php */