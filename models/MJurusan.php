<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MJurusan extends CI_Model {

	public function tampil()
	{
		$this->db->order_by('id_jurusan', 'desc');
		$ambil = $this->db->get('jurusan');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$this->db->insert('jurusan', $inputan);
	}

	public function detail($id_jurusan)
	{
		$this->db->where('id_jurusan', $id_jurusan);
		$ambil = $this->db->get('jurusan');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_jurusan)
	{
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->update('jurusan', $inputan);
	}
	
	public function hapus($id_jurusan)
	{
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->delete('jurusan');
	}

}

/* End of file MJurusan.php */
/* Location: ./application/models/MJurusan.php */