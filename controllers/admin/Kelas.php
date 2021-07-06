<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/* End of file Kelas.php */
/* Location: ./application/controllers/admin/Kelas.php */
/**
 * 
 */
class Kelas extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MKelas');
		$this->load->model('MJurusan');
	}
	
	function index()
	{
		$data['kelas'] = $this->MKelas->tampil();
		//melempar tampilan ke view
		$this->load->view('admin/header');
		$this->load->view('admin/kelas/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$data['jurusan'] = $this->MJurusan->tampil();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('id_jurusan', 'Nama Jurusan','required');
		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
		$this->form_validation->set_rules('tingkat_kelas', 'Tingkat Kelas', 'required');
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');

		if($this->form_validation->run()== TRUE){
			$inputan = $this->input->post();
			$hasil = $this->MKelas->tambah($inputan);
			if($hasil=="sukses"){
				redirect('admin/kelas','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}
		$this->load->view('admin/header');
		$this->load->view('admin/kelas/tambah', $data);
		$this->load->view('admin/footer');	
	}

	public function ubah($id_kelas)
	{
		$data['jurusan'] = $this->MJurusan->tampil();
		$data['detail'] = $this->MKelas->detail($id_kelas);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_jurusan', 'Nama Jurusan', 'required');
		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
		$this->form_validation->set_rules('tingkat_kelas', 'Tingkat Kelas', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run() == TRUE ) {
			$inputan = $this->input->post();
			$this->MKelas->ubah($inputan, $id_kelas);
			redirect('admin/kelas','refresh');
		} 
		
		$this->load->view('admin/header');
		$this->load->view('admin/kelas/ubah', $data);
		$this->load->view('admin/footer');		
	}

	public function hapus($id_kelas)
	{
		$this->MKelas->hapus($id_kelas);
		redirect('admin/kelas','refresh');
	}
} 
?>