 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Siswa extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MSiswa');
	}

	public function index()
	{
		$data['siswa'] = $this->MSiswa->tampil();
		$this->load->view('admin/header');
		$this->load->view('admin/siswa/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function tambah()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nis_siswa', 'Nomor Induk Siswa', 'required|is_unique[siswa.nis_siswa]');
		$this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
		$this->form_validation->set_rules('alamat_siswa', 'Alamat Siswa', 'required');
		$this->form_validation->set_rules('tempat_lahir_siswa', 'Tempat Lahir Siswa', 'required');
		$this->form_validation->set_rules('tanggal_lahir_siswa', 'Tanggal Lahir Siswa', 'required');
		$this->form_validation->set_rules('jk_siswa', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('notelp_siswa', 'Nomor Telepon', 'required');
		$this->form_validation->set_rules('agama_siswa', 'Agama', 'required');
		$this->form_validation->set_rules('ayah_siswa', 'Ayah Siswa', 'required');
		$this->form_validation->set_rules('ibu_siswa', 'Ibu Siswa', 'required');
		$this->form_validation->set_rules('kerja_ayah', 'Kerja Ayah', 'required');
		$this->form_validation->set_rules('kerja_ibu', 'Kerja Ibu', 'required');
		$this->form_validation->set_rules('username_siswa', 'Username Siswa', 'required');
		$this->form_validation->set_rules('password_siswa', 'Password Siswa', 'required');
		
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s Sudah ada coba lagi');

		$inputan = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$this->MSiswa->tambah($inputan);
			redirect('admin/siswa','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/siswa/tambah');
		$this->load->view('admin/footer');
	}

	public function ubah($id_siswa)
	{
		$data['detail'] = $this->MSiswa->detail($id_siswa);
		$inputan = $this->input->post();
		if($inputan){
			$this->MSiswa->ubah($inputan, $id_siswa);
			redirect('admin/siswa','refresh');
		}
		$this->load->view('admin/header');
		$this->load->view('admin/siswa/ubah', $data);
		$this->load->view('admin/footer');	
	}

	public function hapus($id_siswa)
	{
		$this->MSiswa->hapus($id_siswa);
		redirect('admin/siswa','refresh');
	}

	public function detail($id_siswa)
	{
		$data['detail'] = $this->MSiswa->detail($id_siswa);
		$this->load->view('admin/header');
		$this->load->view('admin/siswa/detail', $data);
		$this->load->view('admin/footer');		
	}
} 


/* End of file Siswa.php */
/* Location: ./application/controllers/admin/Siswa.php */
?>