<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MEkstra extends CI_Model
{

	public function cek($id_semester, $id_siswa_kelas)	
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$ambil = $this->db->get('ekstra');
		$array = $ambil->row_array();
		return $array;
	}
	
	public function simpan($id_semester, $inputan)
	{
		foreach ($inputan['keterangan_ekstra'] as $key => $value) {
			$cek = $this->cek($id_semester, $key);
			if(empty($cek)){
				$data_tambah['id_semester'] = $id_semester;
				$data_tambah['id_siswa_kelas'] = $key;
				$data_tambah['keterangan_ekstra'] = $value;
				$this->db->insert('ekstra', $data_tambah);
			}else{
				$data_ubah['keterangan_ekstra'] = $value;
				$this->db->where('id_ekstra', $cek['id_ekstra']);
				$this->db->update('ekstra', $data_ubah);
			}
		}
	} 

	//untuk tampil ekstra di admin maupun guru
	public function tampil()
	{
	 	// $this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('ekstra');
		$array = $ambil->result_array();
		//untuk mengganti index jadi siswakelas
		// foreach ($array as $key => $value) {
		// 	$data[$value['id_siswa_kelas']] = $value;
		// }
		return $array;
	} 

	public function tampil_status($keterangan_ekstra)
	{
	 	$this->db->where('keterangan_ekstra', $keterangan_ekstra);
		$ambil = $this->db->get('ekstra');
		$array = $ambil->result_array();
		//untuk mengganti index jadi siswakelas
		// foreach ($array as $key => $value) {
		// 	$data[$value['id_siswa_kelas']] = $value;
		// }
		return $array;
	} 

	//untuk tambah di admin
	public function tambah($inputan)
	{
		$this->db->insert('ekstra', $inputan);
	}

	//Untuk mengubah di admin
	public function ubah($inputan, $id_ekstra)
	{
		$this->db->where('id_ekstra', $id_ekstra);
		$this->db->update('ekstra', $inputan);
	}
	
	public function hapus($id_ekstra)
	{
		$this->db->where('id_ekstra', $id_ekstra);
		$this->db->delete('ekstra');
	}

	public function detail($id_ekstra)
	{
		$this->db->where('id_ekstra', $id_ekstra);
		$ambil = $this->db->get('ekstra');
		$array = $ambil->row_array();
		return $array;
	}
}


/* End of file MSikap.php */
/* Location: ./application/models/MSikap.php */
?>