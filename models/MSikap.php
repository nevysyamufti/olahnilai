 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MSikap extends CI_Model
{

	public function cek($id_semester, $id_siswa_kelas)	
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$ambil = $this->db->get('sikap');
		$array = $ambil->row_array();
		return $array;
	}
	
	public function simpan($id_semester, $inputan)
	{
		foreach ($inputan['keterangan_sikap'] as $key => $value) {
			$cek = $this->cek($id_semester, $key);
			if(empty($cek)){
				$data_tambah['id_semester'] = $id_semester;
				$data_tambah['id_siswa_kelas'] = $key;
				$data_tambah['keterangan_sikap'] = $value;
				$this->db->insert('sikap', $data_tambah);
			}else{
				$data_ubah['keterangan_sikap'] = $value;
				$this->db->where('id_sikap', $cek['id_sikap']);
				$this->db->update('sikap', $data_ubah);
			}
		}
	} 

	public function tampil()
	{
		// $this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('sikap');
		$array = $ambil->result_array();
		//untuk mengganti index jadi siswakelas
		foreach ($array as $key => $value) {
			$data[$value['id_siswa_kelas']] = $value;
		}
		return $data;
	} 

	function tampil_rapor($id_siswa_kelas, $id_semester)
	{
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('sikap');
		$array = $ambil->row_array();
		return $array;
	}

	function sikap_persemester($id_semester)
	{
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('sikap');
		$array = $ambil->result_array();
		foreach ($array as $key => $value) {
			$data[$value['id_siswa_kelas']] = $value;
		}
		return $data;
	}
}


/* End of file MSikap.php */
/* Location: ./application/models/MSikap.php */
?>