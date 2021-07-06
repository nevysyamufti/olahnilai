<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Walikelas extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MWalikelas');
		$this->load->model('MTahun');
		$this->load->model('MGuru');
		$this->load->model('MKelas');
	}

	public function index()
	{
		$data['walikelas'] = $this->MWalikelas->tampil();

		$this->load->view('admin/header');
		$this->load->view('admin/walikelas/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$data['tahun'] = $this->MTahun->tampil();
		$data['guru'] = $this->MGuru->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun Ajaran','required');
		$this->form_validation->set_rules('id_guru', 'Guru','required');
		$this->form_validation->set_rules('id_kelas', 'Kelas','required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');

		if($this->form_validation->run()== TRUE){
			$inputan = $this->input->post();
			$hasil = $this->MWalikelas->tambah($inputan);
			if($hasil=="sukses"){
				redirect('admin/walikelas','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}

		$this->load->view('admin/header');
		$this->load->view('admin/walikelas/tambah',$data);
		$this->load->view('admin/footer');
	}

	public function ubah($id_wali_kelas)
	{
		$data['tahun'] = $this->MTahun->tampil();
		$data['guru'] = $this->MGuru->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		$data['detail'] = $this->MWalikelas->detail($id_wali_kelas);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun Ajaran','required');
		$this->form_validation->set_rules('id_guru', 'Guru','required');
		$this->form_validation->set_rules('id_kelas', 'Kelas','required');
		$this->form_validation->set_message('required', '%s tidak boleh kososng');


		if ($this->form_validation->run() == TRUE ) {
			$inputan = $this->input->post();
			$this->MWalikelas->ubah($inputan, $id_wali_kelas);
			redirect('admin/walikelas','refresh');
		}

		$this->load->view('admin/header');
		$this->load->view('admin/walikelas/ubah',$data);
		$this->load->view('admin/footer');
	}

	public function hapus($id_wali_kelas)
	{
		$this->MWalikelas->hapus($id_wali_kelas);
		redirect('admin/walikelas','refresh');
	}
} 


/* End of file Walikelas.php */
/* Location: ./application/controllers/admin/Walikelas.php */
?>