<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/* End of file MKepsek.php */
/* Location: ./application/models/MKepsek.php */
/**
 * 
 */
class MKepsek extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('kepala_sekolah');
		$array = $ambil->result_array();
		return $array;
	}

	public function tampil_aktif()
	{
		$this->db->where('status_kepala_sekolah', 'Aktif');
		$ambil = $this->db->get('kepala_sekolah');
		$array = $ambil->row_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$inputan['password_kepala_sekolah'] = md5($inputan['password_kepala_sekolah']); 
		$this->db->insert('kepala_sekolah', $inputan);
	}

	public function detail($id_kepala_sekolah)
	{

		$this->db->where('id_kepala_sekolah', $id_kepala_sekolah);
		$ambil = $this->db->get('kepala_sekolah');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_kepala_sekolah)
	{
		if (!empty($inputan['password_kepala_sekolah'])) {
			$inputan['password_kepala_sekolah'] = md5($inputan['password_kepala_sekolah']);
		}else{
			unset($inputan['password_kepala_sekolah']);
		}
		
		$this->db->where('id_kepala_sekolah', $id_kepala_sekolah);
		$this->db->update('kepala_sekolah', $inputan);
	}

	public function hapus($id_kepala_sekolah)
	{
		$this->db->where('id_kepala_sekolah', $id_kepala_sekolah);
		$this->db->delete('kepala_sekolah');
	}
}
 ?>