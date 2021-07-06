<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Ekstra extends CI_controller
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
		$this->load->model('MEkstra');
		$this->load->model('MNilaiekstra');
	}

	public function index()
	{
		$guru = $this->session->userdata('guru');
		$tampil_kelas = $this->MWalikelas->tampil_kelas(tahun_aktif(), $guru['id_guru']);
		$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $tampil_kelas['id_kelas']);
		//untuk mengotomatiskan semester yang aktif
		$data_semester = $this->MSemester->semester_aktif();
		//untuk menampilkan yang telah disimpan
		$data['ekstra'] = $this->MEkstra->tampil_status("Aktif");
		//untuk menampilkan data
		$data['nilai'] = $this->MNilaiekstra->tampil(tahun_aktif(), $tampil_kelas['id_kelas'], $data_semester['id_semester']);

		$inputan = $this->input->post();
		if ($inputan) {
			$this->MNilaiekstra->simpan($data_semester['id_semester'], $inputan);
			redirect('guru/ekstra','refresh');
		} 

		$this->load->view('guru/header');
		$this->load->view('guru/ekstra/tampil', $data);
		$this->load->view('guru/footer');
	}

}


/* End of file Sikap.php */
/* Location: ./application/controllers/guru/Sikap.php */
 ?>