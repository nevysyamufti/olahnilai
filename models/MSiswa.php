 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MSiswa extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('siswa');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$config['upload_path'] = './assets/img/siswa/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$mengupload = $this->upload->do_upload('foto_siswa');
		//jika proses berhasil maka ambil nama file nya untuk disimpan ke db
		$inputan['password_siswa'] = md5($inputan['password_siswa']); 

		if ($mengupload) {
			$inputan['foto_siswa'] = $this->upload->data("file_name");
		}
		$this->db->insert('siswa', $inputan);
	}

	public function detail($id_siswa)
	{
		$this->db->where('id_siswa', $id_siswa);
		$ambil = $this->db->get('siswa');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_siswa)
	{
		$config['upload_path'] = './assets/img/siswa/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$mengupload = $this->upload->do_upload('foto_siswa');
		if ($mengupload){
			$inputan['foto_siswa'] = $this->upload->data('file_name');
			$data_lama = $this->detail($id_siswa);
			$foto_lama = $data_lama['foto_siswa'];
			if (file_exists("./assets/img/siswa/".$foto_lama)) {
				//jika ada maka hapus foto menggunakan unlink
				unlink("./assets/img/siswa/".$foto_lama);
			}
		}

		if (!empty($inputan['password_siswa'])) {
			$inputan['password_siswa'] = md5($inputan['password_siswa']);
		}else{
			unset($inputan['password_siswa']);
		}

		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $inputan);
	}

	public function hapus($id_siswa)
	{
		$this->db->where('id_siswa', $id_siswa);
		$this->db->delete('siswa');
	}

	public function ubah_profil($inputan, $id_siswa)
	{
		//mengubha data base dengan cara memanggil fungsi ubah
		$this->ubah($inputan, $id_siswa);
		//setelah diubah di db lalu mengambil data nya di fungsi detail
		$data_siswa = $this->detail($id_siswa);
		//setelah diambil data nya lalu membuat session siswa
		$this->session->set_userdata('siswa', $data_siswa);
	}

	public function ubah_password($inputan, $id_siswa)
	{
		//mengubah data pw ke db
		$inputan_baru['password_siswa'] = md5($inputan['password_baru']);
		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $inputan_baru);
		//mengubah data ke session
		$data_siswa = $this->detail($id_siswa);
		$this->session->set_userdata('siswa', $data_siswa);
	}

	public function siswa_tanpa_kelas()
	{
		$semua_siswa = $this->tampil();
		foreach ($semua_siswa as $key => $value) {
			$this->db->where('id_siswa', $value['id_siswa']);
			$ambil = $this->db->get('siswa_kelas');
			$hitung = $ambil->num_rows();
			if ($hitung==0) {
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
} 



/* End of file MSiswa.php */
/* Location: ./application/models/MSiswa.php */
?>