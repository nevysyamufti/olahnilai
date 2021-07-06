<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MSemester extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('semester');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$this->db->insert('semester', $inputan);
	}

	public function detail($id_semester)
	{
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('semester');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_semester)
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->update('semester', $inputan);
	}

	public function hapus($id_semester)
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->delete('semester');
	}

	public function semester_aktif()
	{
		$this->db->where('status_semester', 'Aktif');
		$ambil = $this->db->get('semester');
		$array = $ambil->row_array();
		return $array;
	}
}


/* End of file MSemester.php */
/* Location: ./application/models/MSemester.php */
 ?>