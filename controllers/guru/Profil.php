<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Profil extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("guru")) {
			redirect('','refresh');
		}
		// $this->load->model('MProfil');
		$this->load->model('MGuru');
	}

	public function index()
	{
		$data['guru'] = $this->session->userdata('guru');
		$this->load->view('guru/header');
		$this->load->view('guru/profil/profil', $data);
		$this->load->view('guru/footer');

	}

	public function ubah_profil()
	{
		$data['guru'] = $this->session->userdata('guru');

		$inputan = $this->input->post();
		if($inputan){
			$this->MGuru->ubah_profil($inputan, $data['guru']['id_guru']);
			redirect('guru/profil','refresh');
		}
		// $inputan = $this->input->post();
		// if($inputan){
		// 	$this->MProfil->ubah($inputan);
		// 	redirect('admin/profil','refresh');
		// }

		$this->load->view('guru/header');
		$this->load->view('guru/profil/ubah_profil', $data);
		$this->load->view('guru/footer');
	}

	public function ubah_password()
	{
		$this->load->library('form_validation');
		$data['pesan'] = "";
		$data['guru'] = $this->session->userdata('guru');
		
		$inputan = $this->input->post();
		if($inputan){
			//jika password lama diisi maka cek apakah password lama benar
			if (md5($inputan['password_lama'])==$data['guru']['password_guru']) {
				//pw baru tidak boleh kosong
				if (!empty($inputan['password_baru'])) {
					//jika pw baru sama dengan pw konfirmasi
					if ($inputan['password_baru']==$inputan['password_konfirmasi']) {
						$this->MGuru->ubah_password($inputan, $data['guru']['id_guru']);
						redirect('guru/profil','refresh');
					}else{
						$data['pesan'] = "pesan_3";
					}
				}else{
					$data['pesan'] = "pesan_2";
				}
			}else{
				$data['pesan_1'] = "pesan_1";
			}
		}

		$this->load->view('guru/header');
		$this->load->view('guru/profil/ubah_password', $data);
		$this->load->view('guru/footer');
	}
}

/* End of file Profil.php */
/* Location: ./application/controllers/siswa/Profil.php */
?>