 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MWalikelas extends CI_Model
{
	
	public function tampil()
	{
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = wali_kelas.id_tahun_ajaran');
		$this->db->join('guru', 'guru.id_guru = wali_kelas.id_guru');
		$this->db->join('kelas', 'kelas.id_kelas = wali_kelas.id_kelas');

		$ambil = $this->db->get('wali_kelas');
		$array = $ambil->result_array();
		return $array;
	}

	public function cek($id_tahun_ajaran, $id_guru, $id_kelas)
	{
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_guru', $id_guru);
		$this->db->where('id_kelas', $id_kelas);

		$ambil = $this->db->get('wali_kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$cek = $this->cek($inputan['id_tahun_ajaran'], $inputan['id_guru'], $inputan['id_kelas']);
		if(empty($cek)){
			$this->db->insert('wali_kelas', $inputan);
			return "sukses";
		}
	}

	public function detail($id_wali_kelas)
	{
		$this->db->where('id_wali_kelas', $id_wali_kelas);
		$ambil = $this->db->get('wali_kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_wali_kelas)
	{
		//$data_lama = $this->detail($id_wali_kelas);
		//if ($inputan['id_tahun_ajaran']==$data_lama['id_tahun_ajaran'] AND $inputan['id_guru']==$data_lama['id_guru'] AND $inputan['id_kelas']==$data_lama['id_kelas']) {
		//	return "sukses";
		//}else{
		//$cek = $this->cek($inputan['id_tahun_ajaran'], $inputan['id_guru'], $inputan['id_kelas']);
		//if(empty($cek)){
			$this->db->where('id_wali_kelas', $id_wali_kelas);
			$this->db->update('wali_kelas', $inputan);
		//	return "sukses";
		//	}
		//} 
	}

	public function hapus($id_wali_kelas)
	{
		$this->db->where('id_wali_kelas', $id_wali_kelas);
		$this->db->delete('wali_kelas');
	}

	public function tampil_kelas($id_tahun_ajaran, $id_guru)
	{
		$this->db->join('kelas', 'kelas.id_kelas = wali_kelas.id_kelas');
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_guru', $id_guru);
		$ambil = $this->db->get('wali_kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function tampil_rapor($id_tahun_ajaran, $id_kelas)
	{
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_kelas', $id_kelas);
		$this->db->join('guru', 'guru.id_guru = wali_kelas.id_guru');
		$ambil = $this->db->get('wali_kelas');
		$array = $ambil->row_array();
		return $array;
	}
}


/* End of file MWalikelas.php */
/* Location: ./application/models/MWalikelas.php */
?>