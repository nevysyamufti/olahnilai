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
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		$this->load->model('MDetailguru');
	}

	public function index()
	{
		$guru = $this->session->userdata("guru");
		$tahun_ajaran = $this->session->userdata('tahun_ajaran');
		$data['detailguru'] = $this->MDetailguru->tampil_tahun_guru($guru['id_guru'], $tahun_ajaran['id_tahun_ajaran']);
		$this->load->view('guru/header');
		$this->load->view('guru/detailguru/tampil', $data);
		$this->load->view('guru/footer');
	}
}


/* End of file Detailguru.php */
/* Location: ./application/controllers/guru/Detailguru.php */
 ?>