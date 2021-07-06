<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MLogin extends CI_Model
{
	
	public function login($inputan)
	{
		//intinya login adalah mencocokan data yang diinputkan di form dengan di db
		//setelah cocok maka disimpan dlm session
		//session adl tempat menyimpan data sementara di dlm browser
		//1. password di enkripsi agar sesuai dnegan di db
		$password = md5($inputan['kata_sandi']);
		//2. mengecek login admin
		$this->db->where('email_admin', $inputan['id_akun']);
		$this->db->where('password_admin', $password);
		$ambil_admin = $this->db->get('admin');
		//setelah dicek dihitung menggunkan num_rows
		$hitung_admin = $ambil_admin->num_rows();
		//jika hitung_admin == 1 maka lanjut
		if ($hitung_admin==1) {
			$data_admin = $ambil_admin->row_array();
			//membuat session yang bernama admin lalu masukkan data admin
			$this->session->set_userdata('admin', $data_admin);
			//mengembalikan kata sukses/admin
			return "admin";
		}else{
			//cek apakah kepsek
			$username = $inputan['id_akun'];
			$ambil_kepala = $this->db->query("SELECT * FROM kepala_sekolah WHERE (nip_kepala_sekolah='$username' OR username_kepala_sekolah='$username') AND password_kepala_sekolah='$password'");

			$hitung_kepala = $ambil_kepala->num_rows();
			if($hitung_kepala==1){
				$data_kepala = $ambil_kepala->row_array();
				$this->session->set_userdata("kepala_sekolah", $data_kepala);

				$this->load->model('MTahun');
				$data_tahun =  $this->MTahun->tahun_aktif();
				$this->session->set_userdata('tahun_ajaran', $data_tahun);

				return "kepala_sekolah";
			}else{
			//apakah guru
				// $this->db->where('username_guru', $inputan['id_akun']);
				// $this->db->where('password_guru', $password);
				// $ambil_guru = $this->db->get('guru');

				//agar bisa nip/userrname
				$username = $inputan['id_akun'];
				$ambil_guru = $this->db->query("SELECT * FROM guru WHERE (nip_guru='$username' OR username_guru='$username') AND password_guru='$password'");

				$hitung_guru = $ambil_guru->num_rows();
				if($hitung_guru==1){
					$data_guru = $ambil_guru->row_array();
					$this->session->set_userdata("guru", $data_guru);

					$this->load->model('MTahun');
					$data_tahun =  $this->MTahun->tahun_aktif();
					$this->session->set_userdata('tahun_ajaran', $data_tahun);

					return "guru";
				}else{
			//apakah siswa
					// $this->db->where('nis_siswa', $inputan['id_akun']);
					// $this->db->where('password_siswa', $password);

					//agar bisa usernname atau nik
					$username = $inputan['id_akun'];
					$ambil_siswa = $this->db->query("SELECT * FROM siswa WHERE (nis_siswa='$username' OR username_siswa='$username') AND password_siswa='$password'");
					
					$hitung_siswa = $ambil_siswa->num_rows();
					if($hitung_siswa==1){
						$data_siswa = $ambil_siswa->row_array();
						$this->session->set_userdata("siswa", $data_siswa);

						$this->load->model('MTahun');
						$data_tahun =  $this->MTahun->tahun_aktif();
						$this->session->set_userdata('tahun_ajaran', $data_tahun);
						
						return "siswa";
					}else{
			//apakah ortu
						$this->db->where('username_ortu', $inputan['id_akun']);
						$this->db->where('password_ortu', $password);
						$ambil_ortu = $this->db->get('ortu');
						$hitung_ortu = $ambil_ortu->num_rows();
						if($hitung_ortu==1){
							$data_ortu = $ambil_ortu->row_array();
							$this->session->set_userdata("ortu", $data_ortu);

							return "ortu";
						}else{
							return "gagal";
						}
					}
				}
			}
		}
	}
}
/* End of file MLogin.php */
/* Location: ./application/models/MLogin.php */
?>