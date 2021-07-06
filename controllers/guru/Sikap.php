 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Sikap extends CI_controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		$this->load->model('MWalikelas');
		$this->load->model('MSiswakelas');
		$this->load->model('MSemester');
		$this->load->model('MSikap');
	}

	public function index()
	{
		$guru = $this->session->userdata('guru');
		$tampil_kelas = $this->MWalikelas->tampil_kelas(tahun_aktif(), $guru['id_guru']);
		$data['siswa'] = $this->MSiswakelas->tampil_siswa(tahun_aktif(), $tampil_kelas['id_kelas']);
		//untuk mengotomatiskan semester yang aktif
		$data_semester = $this->MSemester->semester_aktif();

		$data['sikap'] = $this->MSikap->sikap_persemester($data_semester['id_semester']);

		$inputan = $this->input->post();
		if ($inputan) {
			$this->MSikap->simpan($data_semester['id_semester'], $inputan);
			redirect('guru/sikap','refresh');
		} 

		$this->load->view('guru/header');
		$this->load->view('guru/sikap/tampil', $data);
		$this->load->view('guru/footer');
	}

}


/* End of file Sikap.php */
/* Location: ./application/controllers/guru/Sikap.php */
 ?>