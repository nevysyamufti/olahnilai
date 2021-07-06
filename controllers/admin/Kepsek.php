<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Kepsek extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MKepsek');
	}

	public function index()
	{
		$data['kepsek'] = $this->MKepsek->tampil();

		$this->load->view('admin/header');
		$this->load->view('admin/kepsek/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_kepala_sekolah', 'Nama Kepala Sekolah', 'required|is_unique[kepala_sekolah.nama_kepala_sekolah]');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		$inputan = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$this->MKepsek->tambah($inputan);
			redirect('admin/kepsek','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/kepsek/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_kepala_sekolah)
	{
		$data['detail'] = $this->MKepsek->detail($id_kepala_sekolah);
		$this->load->library('form_validation');

		$inputan = $this->input->post();
		if($inputan and $inputan['nama_kepala_sekolah']!==$data['detail']['nama_kepala_sekolah'])
		{
			$is_unique = "|is_unique[kepala_sekolah.nama_kepala_sekolah]";
		}
		else
		{
			$is_unique = "";
		}
		$this->form_validation->set_rules('nama_kepala_sekolah', 'Nama Kepala Sekolah', 'required'.$is_unique);
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		if($this->form_validation->run()==TRUE){

			$this->MKepsek->ubah($inputan, $id_kepala_sekolah);
			redirect('admin/kepsek','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/kepsek/ubah',$data);
		$this->load->view('admin/footer');		
	}

	public function hapus($id_kepala_sekolah)
	{
		$this->MKepsek->hapus($id_kepala_sekolah);
		redirect('admin/kepsek','refresh');
	}
}


/* End of file Kepsek.php */
/* Location: ./application/controllers/admin/Kepsek.php */
?>