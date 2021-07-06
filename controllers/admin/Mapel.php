  <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Mapel extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MMapel');
		$this->load->model('MJurusan');
	}

	public function index()
	{
		$data['mapel'] = $this->MMapel->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/mapel/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$data['jurusan'] = $this->MJurusan->tampil();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('id_jurusan', 'Nama Jurusan','required');
		$this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
		$this->form_validation->set_rules('kkm_mapel', 'KKM', 'required');
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');
		//$this->form_validation->set_message('is_unique', '%s sudah ada coba lagi');

		if($this->form_validation->run()== TRUE){
			$inputan = $this->input->post();
			$hasil = $this->MMapel->tambah($inputan);
			if($hasil=="sukses"){
				redirect('admin/mapel','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}
		$this->load->view('admin/header');
		$this->load->view('admin/mapel/tambah',$data);
		$this->load->view('admin/footer');
	}

	public function ubah($id_mapel)
	{
		$data['jurusan'] = $this->MJurusan->tampil();
		$data['detail'] = $this->MMapel->detail($id_mapel);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_jurusan', 'Nama Jurusan', 'required');
		$this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required'); 
		$this->form_validation->set_message('required', '%s tidak boleh kosong');

		if ($this->form_validation->run() == TRUE ) {
			$inputan = $this->input->post();
			$hasil = $this->MMapel->ubah($inputan, $id_mapel);
			if($hasil=="sukses"){
				redirect('admin/mapel','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}
		$this->load->view('admin/header');
		$this->load->view('admin/mapel/ubah',$data);
		$this->load->view('admin/footer');
	}

	public function hapus($id_mapel)
	{
		$this->MMapel->hapus($id_mapel);
		redirect('admin/mapel','refresh');
	}
}


/* End of file Mapel.php */
/* Location: ./application/controllers/admin/Mapel.php */
?>