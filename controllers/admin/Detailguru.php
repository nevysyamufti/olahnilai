 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Detailguru extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MDetailguru');
		$this->load->model('MTahun');
		$this->load->model('MGuru');
		$this->load->model('MKelas');
		$this->load->model('MMapel');
	}

	public function index()
	{
		$data['detailguru'] = $this->MDetailguru->tampil();

		$this->load->view('admin/header');
		$this->load->view('admin/detailguru/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$data['tahun'] = $this->MTahun->tampil();
		$data['guru'] = $this->MGuru->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		$data['mapel'] = $this->MMapel->tampil();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun Ajaran','required');
		$this->form_validation->set_rules('id_guru', 'Guru','required');
		$this->form_validation->set_rules('id_kelas', 'Kelas','required');
		$this->form_validation->set_rules('id_mapel', 'Mapel','required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		
		if($this->form_validation->run()== TRUE){
			$inputan = $this->input->post();
			$hasil = $this->MDetailguru->tambah($inputan);
			if($hasil=="sukses"){
				redirect('admin/detailguru','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}
		$this->load->view('admin/header');
		$this->load->view('admin/detailguru/tambah',$data);
		$this->load->view('admin/footer');
	}

	public function ubah($id_det_guru_mapel)
	{
		$data['tahun'] = $this->MTahun->tampil();
		$data['guru'] = $this->MGuru->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		$data['mapel'] = $this->MMapel->tampil();
		$data['detail'] = $this->MDetailguru->detail($id_det_guru_mapel);

		$this->load->library('form_validation');
		$this->form_validation->set_rules("id_tahun_ajaran", "Tahun Ajaran", 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kososng');

		if($this->form_validation->run() == TRUE){
			$inputan = $this->input->post(); 
			$hasil = $this->MDetailguru->ubah($inputan, $id_det_guru_mapel); 
			if($hasil=="sukses"){
				redirect('admin/detailguru','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan isi kembali</div>');

			}
		}

		$this->load->view('admin/header');
		$this->load->view('admin/detailguru/ubah', $data);
		$this->load->view('admin/footer');
	}


	public function hapus($id_det_guru_mapel)
	{
		$this->MDetailguru->hapus($id_det_guru_mapel);
		redirect('admin/detailguru','refresh');
	} 
}


/* End of file Detailguru.php */
/* Location: ./application/controllers/admin/Detailguru.php */
?> 