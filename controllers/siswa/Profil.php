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
		if (!$this->session->userdata("siswa")) {
			redirect('','refresh');
		}
		$this->load->model('MSiswa');
		$this->load->model('MTahun');
	}

	public function index()
	{
		$data['siswa'] = $this->session->userdata('siswa');
		$this->load->view('siswa/header');
		$this->load->view('siswa/profil/profil', $data);
		$this->load->view('siswa/footer');

	}

	public function ubah_profil()
	{
		$data['siswa'] = $this->session->userdata('siswa');

		$inputan = $this->input->post();
		if($inputan){
			$this->MSiswa->ubah_profil($inputan, $data['siswa']['id_siswa']);
			redirect('siswa/profil','refresh');
		}

		$this->load->view('siswa/header');
		$this->load->view('siswa/profil/ubah_profil', $data);
		$this->load->view('siswa/footer');
	}

	public function ubah_password()
	{
		$this->load->library('form_validation');
		$data['pesan'] = "";
		$data['siswa'] = $this->session->userdata('siswa');
		
		$inputan = $this->input->post();
		if($inputan){
			//jika password lama diisi maka cek apakah password lama benar
			if (md5($inputan['password_lama'])==$data['siswa']['password_siswa']) {
				//pw baru tidak boleh kosong
				if (!empty($inputan['password_baru'])) {
					//jika pw baru sama dengan pw konfirmasi
					if ($inputan['password_baru']==$inputan['password_konfirmasi']) {
						$this->MSiswa->ubah_password($inputan, $data['siswa']['id_siswa']);
						redirect('siswa/profil','refresh');
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

		$this->load->view('siswa/header');
		$this->load->view('siswa/profil/ubah_password', $data);
		$this->load->view('siswa/footer');
	}

	public function cetak()
	{
		$data['siswa'] = $this->session->userdata('siswa');
		$data['tahun'] = $this->MTahun->detail(tahun_aktif());
		$this->load->view('siswa/profil/cetak', $data);
	}
}

/* End of file Profil.php */
/* Location: ./application/controllers/siswa/Profil.php */
?>