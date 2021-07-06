<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MJurusan');

	}

	public function index()
	{
		$data['jurusan'] = $this->MJurusan->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/jurusan/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		//Memanggil library
		$this->load->library('form_validation');
		//membuat rule
		$this->form_validation->set_rules('nama_jurusan', 'Nama jurusan', 'required|is_unique[jurusan.nama_jurusan]');
		//membuat pesan
		$this->form_validation->set_message('required', '%s tidak boleh kososng');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		//menjalakan form validasi. jika benar lanjut menyimpan
		if ($this->form_validation->run() == TRUE){
			$inputan = $this->input->post();
			$this->MJurusan->tambah($inputan);
			redirect('admin/jurusan','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/jurusan/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_jurusan)
	{
		$data['detail'] = $this->MJurusan->detail($id_jurusan);
		$this->load->library('form_validation');
		//mengambil data dari formulir
		$inputan = $this->input->post();
		//jika nama_jurusan tdak sama dengan dirinya sendriri maka
		if($inputan and $inputan['nama_jurusan']!==$data['detail']['nama_jurusan'])
		{
			$is_unique = "|is_unique[jurusan.nama_jurusan]";
		}
		else {
			$is_unique ="";
		}
		$this->form_validation->set_rules("nama_jurusan", "Nama jurusan", 'required'.$is_unique);
		$this->form_validation->set_message('required', '%s tidak boleh kososng');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		if ($this->form_validation->run() == TRUE) {
			$this->MJurusan->ubah($inputan, $id_jurusan);
			redirect('admin/jurusan','refresh');
		} 
		$this->load->view('admin/header');
		$this->load->view('admin/jurusan/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_jurusan)
	{
		$this->MJurusan->hapus($id_jurusan);
		redirect('admin/jurusan','refresh');
	}

}


/* End of file Jurusan.php */
/* Location: ./application/controllers/admin/Jurusan.php */