<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ekstra extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MEkstra');

	}

	public function index()
	{
		$data['ekstra'] = $this->MEkstra->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/ekstra/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		//Memanggil library
		$this->load->library('form_validation');
		//membuat rule
		$this->form_validation->set_rules('nama_ekstra', 'Nama ekstra', 'required|is_unique[ekstra.nama_ekstra]');
		//$this->form_validation->set_rules('keterangan_ekstra', 'keterangan ekstra', 'required|is_unique[ekstra.keterangan_ekstra]');
		//membuat pesan
		$this->form_validation->set_message('required', '%s tidak boleh kososng');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		//menjalakan form validasi. jika benar lanjut menyimpan
		if ($this->form_validation->run() == TRUE){
			$inputan = $this->input->post();
			$this->MEkstra->tambah($inputan);
			redirect('admin/ekstra','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/ekstra/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_ekstra)
	{
		$data['detail'] = $this->MEkstra->detail($id_ekstra);
		$this->load->library('form_validation');
		//mengambil data dari formulir
		$inputan = $this->input->post();
		//jika nama_ekstra tdak sama dengan dirinya sendriri maka
		if($inputan and $inputan['nama_ekstra']!==$data['detail']['nama_ekstra'])
		{
			$is_unique = "|is_unique[ekstra.nama_ekstra]";
		}
		else {
			$is_unique ="";
		}
		$this->form_validation->set_rules("nama_ekstra", "Nama ekstra", 'required'.$is_unique);
		$this->form_validation->set_message('required', '%s tidak boleh kososng');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		if ($this->form_validation->run() == TRUE) {
			$this->MEkstra->ubah($inputan, $id_ekstra);
			redirect('admin/ekstra','refresh');
		} 
		$this->load->view('admin/header');
		$this->load->view('admin/ekstra/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_ekstra)
	{
		$this->MEkstra->hapus($id_ekstra);
		redirect('admin/ekstra','refresh');
	}

}


/* End of file ekstra.php */
/* Location: ./application/controllers/admin/Jurusan.php */