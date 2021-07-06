<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MAdmin extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('admin');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$inputan['password_admin'] = md5($inputan['password_admin']); 
		$this->db->insert('admin', $inputan);
	}

	public function detail($id_admin)
	{
		$this->db->where('id_admin', $id_admin);
		$ambil = $this->db->get('admin');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_admin)
	{
		if (!empty($inputan['password_admin'])) {
			$inputan['password_admin'] = md5($inputan['password_admin']);
		}else{
			unset($inputan['password_admin']);
		}

		$this->db->where('id_admin', $id_admin);
		$this->db->update('admin', $inputan);
	}

	public function hapus($id_admin)
	{
		$this->db->where('id_admin', $id_admin);
		$this->db->delete('admin');
	}
}



/* End of file MAdmin.php */
/* Location: ./application/models/MAdmin.php */
?>