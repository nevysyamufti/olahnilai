<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Admin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MAdmin');
	}

	public function index()
	{
		$data['administrator'] = $this->MAdmin->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/admin/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required|is_unique[admin.nama_admin]');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		if($this->form_validation->run() == TRUE) {
			$inputan = $this->input->post();
			$this->MAdmin->tambah($inputan);
			redirect('admin/admin','refresh');
		}

		$this->load->view('admin/header');
		$this->load->view('admin/admin/tambah');
		$this->load->view('admin/footer');	
	}

	public function ubah($id_admin)
	{
		$data['detail'] = $this->MAdmin->detail($id_admin);
		$this->load->library('form_validation');

		$inputan = $this->input->post();

		if ($inputan and $inputan['nama_admin']!==$data['detail']['nama_admin'])
		{
			$is_unique = "|is_unique[admin.nama_admin]";
		}
		else
		{
			$is_unique = "";
		}
		$this->form_validation->set_rules("nama_admin", "Nama Admin", 'required'.$is_unique);
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		if ($this->form_validation->run() == TRUE) {
			$this->MAdmin->ubah($inputan, $id_admin);
			redirect('admin/admin','refresh');
		}

		$this->load->view('admin/header');
		$this->load->view('admin/admin/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_admin)
	{
		$this->MAdmin->hapus($id_admin);
		redirect('admin/admin','refresh');
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/admin/Admin.php */
?>