<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Pengaturan extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MPengaturan');
	}

	public function index()
	{
		$data['pengaturan'] = $this->MPengaturan->tampil();

		$this->load->view('admin/header');
		$this->load->view('admin/pengaturan/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$inputan = $this->input->post();
		if($inputan){
		$this->MPengaturan->tambah($inputan);
		redirect('admin/pengaturan','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/pengaturan/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_pengaturan)
	{
		$data['detail'] = $this->MPengaturan->detail($id_pengaturan);
		$inputan = $this->input->post();
		if($inputan){
			$this->MPengaturan->ubah($inputan, $id_pengaturan);
			redirect('admin/pengaturan','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/pengaturan/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_pengaturan)
	{
		$this->MPengaturan->hapus($id_pengaturan);
		redirect('admin/pengaturan','refresh');
	}

	public function kenaikan()
	{
		$detail = $this->MPengaturan->detail(7);
		$explode = explode(" sd ", $detail['isi_pengaturan']);
		$data['mulai'] = $explode[0];
		$data['selesai'] = $explode[1];
		$inputan = $this->input->post();
		if ($inputan) {
			$this->MPengaturan->ubah_kenaikan($inputan);
			redirect('admin/pengaturan/kenaikan','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/pengaturan/kenaikan', $data);
		$this->load->view('admin/footer');	
	}
}


/* End of file Pengaturan.php */
/* Location: ./application/controllers/admin/Pengaturan.php */

?>