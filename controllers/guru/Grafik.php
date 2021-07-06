<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');

class Grafik extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('guru')){
			redirect('','refresh');
		}
		$this->load->model('MTahun');
		$this->load->model('MSemester');
		$this->load->model('MWalikelas');
		$this->load->model('MSiswakelas');
		$this->load->model('MNilai');
	}

	public function index()
	{
		$data['tahun'] = $this->MTahun->tampil();
		$data['semester'] = $this->MSemester->tampil();
		$inputan = $this->input->post();
		if ($inputan) {
			$data['id_tahun'] = $inputan['id_tahun'];
			$data['id_semester'] = $inputan['id_semester'];
		}else{
			$tahun_aktif = $this->MTahun->tahun_aktif();
			$semester_aktif = $this->MSemester->semester_aktif();
			$data['id_tahun'] = $tahun_aktif['id_tahun_ajaran'];
			$data['id_semester'] = $semester_aktif['id_semester'];
		}
		$data['guru'] = $this->session->userdata("guru");
		$data['kelas'] = $this->MWalikelas->tampil_kelas($data['id_tahun'], $data['guru']['id_guru']);
		$data['siswa'] = $this->MSiswakelas->tampil_siswa($data['id_tahun'], $data['kelas']['id_kelas']);
		//mendapatkan total, untuk presentase
		$total_nilai = 0;

		foreach ($data["siswa"] as $key => $value) {
			$data['nilai'][$value['nama_siswa']] = $this->MNilai->nilai_rata_rata_akhir($data['id_tahun'], $data['id_semester'], $value['id_siswa']);

			$total_nilai+=$this->MNilai->nilai_rata_rata_akhir($data['id_tahun'], $data['id_semester'], $value['id_siswa']);
		}

		$keputusan['diatas'] = array();
		$keputusan['dibawah'] = array();
		//mendapatkan total, untuk presentase
		$rata_rata = $total_nilai / count($data['siswa']);
		
		foreach ($data["siswa"] as $key => $value) {
			$nilai_rata_rata_akhir = $this->MNilai->nilai_rata_rata_akhir($data['id_tahun'], $data['id_semester'], $value['id_siswa']);
			if($nilai_rata_rata_akhir > $rata_rata){
				$keputusan['diatas'][$key] = 1;
			} else {
				$keputusan['dibawah'][$key] = 1;
			}
		}
		$data['persen']['diatas'] = array_sum($keputusan['diatas']) / count($data['siswa']) * 100;
		$data['persen']['dibawah'] = array_sum($keputusan['dibawah']) / count($data['siswa']) * 100;

		$this->load->view('guru/header');
		$this->load->view('guru/grafik', $data);
		$this->load->view('guru/footer');
	}
}
?>