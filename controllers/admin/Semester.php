<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Semester extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('MSemester');	 	
	}

	public function index()
	{
		$data['semester'] = $this->MSemester->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/semester/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_semester', 'Nama Semester', 'required|is_unique[semester.nama_semester]');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');
		$inputan = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$this->MSemester->tambah($inputan);
			redirect('admin/semester','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/semester/tambah');
		$this->load->view('admin/footer');	
	}

	public function ubah($id_semester)
	{
		$data['detail'] = $this->MSemester->detail($id_semester);
		$this->load->library('form_validation');

		$inputan = $this->input->post();
		if($inputan and $inputan['nama_semester']!==$data['detail']['nama_semester'])
		{
			$is_unique = "|is_unique[semester.nama_semester]";
		}
		else
		{
			$is_unique = "";
		}

		$this->form_validation->set_rules('nama_semester', 'Nama Semester', 'required'.$is_unique);
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudag ada coba lagi');
		if($this->form_validation->run()==TRUE){

			$this->MSemester->ubah($inputan, $id_semester);
			redirect('admin/semester','refresh');

		}
		$this->load->view('admin/header');
		$this->load->view('admin/semester/ubah',$data);
		$this->load->view('admin/footer');		
	}

	public function hapus($id_semester)
	{
		$this->MSemester->hapus($id_semester);
		redirect('admin/semester','refresh');
	}
}


/* End of file Semester.php */
/* Location: ./application/controllers/admin/Semester.php */
?>