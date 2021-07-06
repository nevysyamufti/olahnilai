<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lnilai extends CI_Controller 
{

	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("kepala_sekolah")) {
			redirect('','refresh');
		}

		$this->load->model('MNilai');
		$this->load->model('MSiswa');
	}

	public function index()
	{
		$data['siswa'] = $this->MSiswa->tampil();
		// $data['tahun_ajaran'] = $this->MTahun->tampil();
		// $data['kelas'] = $this->MKelas->tampil();
		// $data['tahun_aktif'] = $this->MTahun->tahun_aktif();

		// foreach ($data['siswakelas'] as $key => $value) {
		// 	//explode untuk memisahakan
		// 	$array_kelas = explode(" ", $value['nama_kelas']);
		// 	$tahun_kelas = $array_kelas[0];
		// 	$jurusan_kelas = $array_kelas[1];
		// 	$tingkat_kelas = $value['tingkat_kelas'];
		// 	if ($tahun_kelas < 12) {
		// 		$data['kelas_selanjutnya'][$value['id_siswa_kelas']] = ($tahun_kelas+1)." ".$jurusan_kelas." ".$tingkat_kelas;
		// 		$cek_kelas = $this->MKelas->cek_kelas(($tahun_kelas+1)." ".$jurusan_kelas, $tingkat_kelas);
		$this->load->view('kepsek/header');
		$this->load->view('kepsek/nilai/tampil', $data);
		$this->load->view('kepsek/footer');
	}

		public function detail($id_siswa)
	{
		$data['detni'] =  $this->MNilai->semua_siswa_nilai($id_siswa);
		$data['nilai_rata_rata'] = $this->MNilai->nilai_rata_rata_semua($id_siswa);

		$this->load->view('kepsek/header');
		$this->load->view('kepsek/nilai/detail', $data);
		$this->load->view('kepsek/footer');
	}
}
 
/* End of file Lsiswa.php */
/* Location: ./application/controllers/kepsek/Lsiswa.php */