<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MTahun extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('tahun_ajaran');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$this->db->insert('tahun_ajaran', $inputan);
	}

	public function detail($id_tahun_ajaran)
	{
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$ambil = $this->db->get('tahun_ajaran');
		$array = $ambil->row_array();
		return $array;

	}

	public function ubah($inputan, $id_tahun_ajaran)
	{
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->update('tahun_ajaran', $inputan);
	}

	public function hapus($id_tahun_ajaran)
	{
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->delete('tahun_ajaran');
	}

	public function tahun_aktif()
	{
		$this->db->where('status_tahun_ajaran', "Aktif");
		$ambil = $this->db->get('tahun_ajaran');
		$array = $ambil->row_array();
		return $array;
	}

	public function tahun_berikutnya($id_tahun_ajaran)
	{
		$ambil = $this->db->query("SELECT id_tahun_ajaran FROM tahun_ajaran WHERE id_tahun_ajaran > '$id_tahun_ajaran' LIMIT 1");
		$array = $ambil->row_array();
		return $array['id_tahun_ajaran'];
	}
}


/* End of file MTahun.php */
/* Location: ./application/models/MTahun.php */
?>