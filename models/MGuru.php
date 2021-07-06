<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class MGuru extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('guru');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$config['upload_path'] = './assets/img/guru/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$mengupload = $this->upload->do_upload('foto_guru');
		//jika proses berhasil maka ambil nama file nya untuk disimpan ke db
		$inputan['password_guru'] = md5($inputan['password_guru']); 

		if ($mengupload) {
			$inputan['foto_guru'] = $this->upload->data("file_name");
		}
		$this->db->insert('guru', $inputan);
	}

	public function detail($id_guru)
	{
		$this->db->where('id_guru', $id_guru);
		$ambil = $this->db->get('guru');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_guru)
	{
		$config['upload_path'] = './assets/img/guru/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$mengupload = $this->upload->do_upload('foto_guru');
		if ($mengupload){
			$inputan['foto_guru'] = $this->upload->data('file_name');
			$data_lama = $this->detail($id_guru);
			$foto_lama = $data_lama['foto_guru'];
			if (file_exists("./assets/img/guru/".$foto_lama)) {
				//jika ada maka hapus foto menggunakan unlink
				unlink("./assets/img/guru/".$foto_lama);
			}
		}

		if (!empty($inputan['password_guru'])) {
			$inputan['password_guru'] = md5($inputan['password_guru']);
		}else{
			unset($inputan['password_guru']);
		}

		$this->db->where('id_guru', $id_guru);
		$this->db->update('guru', $inputan);
	}

	public function hapus($id_guru)
	{
		$this->db->where('id_guru', $id_guru);
		$this->db->delete('guru');
	}

	public function ubah_profil($inputan, $id_guru)
	{
		//mengubha data base dengan cara memanggil fungsi ubah
		$this->ubah($inputan, $id_guru);
		//setelah diubah di db lalu mengambil data nya di fungsi detail
		$data_guru = $this->detail($id_guru);
		//setelah diambil data nya lalu membuat session siswa
		$this->session->set_userdata('guru', $data_guru);
	}

	public function ubah_password($inputan, $id_guru)
	{
		//mengubah data pw ke db
		$inputan_baru['password_guru'] = md5($inputan['password_baru']);
		$this->db->where('id_guru', $id_guru);
		$this->db->update('guru', $inputan_baru);
		//mengubah data ke session
		$data_guru = $this->detail($id_guru);
		$this->session->set_userdata('guru', $data_guru);
	}

}
?>