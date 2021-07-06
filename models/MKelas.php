<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MKelas extends CI_Model
{
	
	public function tampil()
	{
		$this->db->join('jurusan', 'jurusan.id_jurusan = kelas.id_jurusan');
		$ambil = $this->db->get('kelas');
		$array = $ambil->result_array();
		return $array;
	}

	public function  cek($id_jurusan, $nama_kelas, $tingkat_kelas)
	{
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->where('nama_kelas', $nama_kelas);
		$this->db->where('tingkat_kelas', $tingkat_kelas);
		$ambil = $this->db->get('kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$cek = $this->cek($inputan['id_jurusan'], $inputan['nama_kelas'], $inputan['tingkat_kelas']);
		if(empty($cek)){
			$this->db->insert('kelas', $inputan);
			return "sukses";
		}

	}

	public function detail($id_kelas)
	{
		$this->db->where('id_kelas', $id_kelas);
		$ambil = $this->db->get('kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_kelas)
	{
		$data_lama = $this->detail($id_kelas);
		if ($inputan['id_jurusan']==$data_lama['id_jurusan'] AND $inputan['nama_kelas']==$data_lama['nama_kelas'] AND $inputan['tingkat_kelas']==$data_lama['tingkat_kelas']) {
			return "sukses";
		}else{
			$cek = $this->cek($inputan['id_jurusan'], $inputan['nama_kelas'], $inputan['tingkat_kelas']);
			if(empty($cek)){
				$this->db->where('id_kelas', $id_kelas);
				$this->db->update('kelas', $inputan);
				return "sukses";
			}
		}
	}

	public function hapus($id_kelas)
	{
		$this->db->where('id_kelas', $id_kelas);
		$this->db->delete('kelas');
	}

	function cek_kelas($nama_kelas, $tingkat_kelas)
	{
		$this->db->where('nama_kelas', $nama_kelas);
		$this->db->where('tingkat_kelas', $tingkat_kelas);
		$ambil = $this->db->get('kelas');
		$data = $ambil->row_array();
		return $data;
	}
}


/* End of file MKelas.php */
/* Location: ./application/models/MKelas.php */
?>