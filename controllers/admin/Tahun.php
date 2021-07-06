<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Tahun extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MTahun');
	}

	public function index()
	{
		$data['tahun'] = $this->MTahun->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/tahun/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$inputan = $this->input->post();
		if($inputan){
			$data['tahun'] = $this->MTahun->tambah($inputan);
			redirect('admin/tahun','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/tahun/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_tahun_ajaran)	
	{
		$data['detail'] = $this->MTahun->detail($id_tahun_ajaran);
		$inputan = $this->input->post();
		if($inputan){
			$this->MTahun->ubah($inputan, $id_tahun_ajaran);
			redirect('admin/tahun', 'refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/tahun/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_tahun_ajaran)
	{
		$this->MTahun->hapus($id_tahun_ajaran);
		redirect('admin/tahun','refresh');
	}


}


/* End of file Tahun.php */
/* Location: ./application/controllers/admin/Tahun.php */
?>