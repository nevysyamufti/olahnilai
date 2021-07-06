<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Guru extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MGuru');
	}

	public function index()
	{
		$data['guru'] = $this->MGuru->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/guru/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nip_guru', 'Nomor Induk Pegawai', 'required|is_unique[guru.nip_guru]');
		$this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required');
		$this->form_validation->set_rules('alamat_guru', 'Alamat Guru', 'required');
		$this->form_validation->set_rules('tempat_lahir_guru', 'Tempat Lahir Guru', 'required');
		$this->form_validation->set_rules('tanggal_lahir_guru', 'Tanggal Lahir Guru', 'required');
		$this->form_validation->set_rules('jk_guru', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('agama_guru', 'Agama', 'required');
		$this->form_validation->set_rules('pendidikan_guru', 'Pendidikan Guru', 'required');
		$this->form_validation->set_rules('notelp_guru', 'Nomor Telepon', 'required');
		$this->form_validation->set_rules('username_guru', 'Username Guru', 'required');
		$this->form_validation->set_rules('password_guru', 'Password Guru', 'trim|required|min_length[5]');
		
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s Sudah ada coba lagi');
		$this->form_validation->set_message('min_length', '% Minimal 5 karakter');

		$inputan = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$this->MGuru->tambah($inputan);
			redirect('admin/guru','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/guru/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_guru)
	{
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('nip_guru', 'Nomor Induk Pegawai', 'required|is_unique[guru.nip_guru]');
		$this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required');
		$this->form_validation->set_rules('alamat_guru', 'Alamat Guru', 'required');
		$this->form_validation->set_rules('tempat_lahir_guru', 'Tempat Lahir Guru', 'required');
		$this->form_validation->set_rules('tanggal_lahir_guru', 'Tanggal Lahir Guru', 'required');
		$this->form_validation->set_rules('jk_guru', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('agama_guru', 'Agama', 'required');
		$this->form_validation->set_rules('pendidikan_guru', 'Pendidikan Guru', 'required');
		$this->form_validation->set_rules('notelp_guru', 'Nomor Telepon', 'required');
		$this->form_validation->set_rules('username_guru', 'Username Guru', 'required');
		$this->form_validation->set_rules('password_guru', 'Password Guru', 'trim|required|min_length[5]');
		
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s Sudah ada coba lagi');
		$this->form_validation->set_message('min_length', '% Minimal 5 karakter');
		
		$data['detail'] = $this->MGuru->detail($id_guru);
		$inputan = $this->input->post();
		if($this->form_validation->run() == TRUE) {
			$this->MGuru->ubah($inputan, $id_guru);
			redirect('admin/guru','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/guru/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_guru)
	{
		$this->MGuru->hapus($id_guru);
		redirect('admin/guru','refresh');
	}

	public function detail($id_guru)
	{
		$data['detail'] = $this->MGuru->detail($id_guru);
		$this->load->view('admin/header');
		$this->load->view('admin/guru/detail', $data);
		$this->load->view('admin/footer');		
	}
}


/* End of file Guru.php */
/* Location: ./application/controllers/admin/Guru.php */
?>