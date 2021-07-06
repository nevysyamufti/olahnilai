 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MDetailguru extends CI_Model
{
	
	public function tampil()
	{
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = det_guru_mapel.id_tahun_ajaran');
		$this->db->join('guru', 'guru.id_guru = det_guru_mapel.id_guru');
		$this->db->join('kelas', 'kelas.id_kelas = det_guru_mapel.id_kelas');
		$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');

		$ambil = $this->db->get('det_guru_mapel');
		$array = $ambil->result_array();
		return $array;
	}

	public function  cek($id_tahun_ajaran, $id_guru, $id_kelas, $id_mapel)
	{ 
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_guru', $id_guru);
		$this->db->where('id_kelas', $id_kelas);
		$this->db->where('id_mapel', $id_mapel);  
		$ambil = $this->db->get('det_guru_mapel');
		$array = $ambil->row_array();
		return $array;
	} 	

	public function tambah($inputan)
	{
		$cek = $this->cek($inputan['id_tahun_ajaran'], $inputan['id_guru'], $inputan['id_kelas'], $inputan['id_mapel']);
		if(empty($cek)){
			$this->db->insert('det_guru_mapel', $inputan);
			return "sukses";
		}
	}

	public function detail($id_det_guru_mapel)
	{

		$this->db->where('id_det_guru_mapel', $id_det_guru_mapel);
		$ambil = $this->db->get('det_guru_mapel');
		$array = $ambil->row_array();
		return $array;

	}

	public function ubah($inputan, $id_det_guru_mapel)
	{
		$cek = $this->cek($inputan['id_tahun_ajaran'], $inputan['id_guru'], $inputan['id_kelas'], $inputan['id_mapel']);
		if(empty($cek)){
			$this->db->where('id_det_guru_mapel', $id_det_guru_mapel);
			$this->db->update('det_guru_mapel', $inputan);
			return "sukses";
		}
	}

	public function hapus($id_det_guru_mapel)
	{
		$this->db->where('id_det_guru_mapel', $id_det_guru_mapel);
		$this->db->delete('det_guru_mapel');
	} 

	public function tampil_tahun_guru($id_guru, $id_tahun_ajaran)
	{
		$this->db->join('kelas', 'kelas.id_kelas = det_guru_mapel.id_kelas');
		$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');
		$this->db->where('id_guru', $id_guru);
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$ambil = $this->db->get('det_guru_mapel');
		$array = $ambil->result_array();
		return $array;
	}

	public function tampil_kelas($id_guru, $id_tahun_ajaran)
	{
	$this->db->join('kelas', 'kelas.id_kelas = det_guru_mapel.id_kelas');
	$this->db->where('id_guru', $id_guru);
	$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
	$this->db->group_by('det_guru_mapel.id_kelas');
	$ambil = $this->db->get('det_guru_mapel');
	$array = $ambil->result_array();
	return $array;

	}

	public function tampil_mapel($id_guru, $id_tahun_ajaran, $id_kelas)
	{
		$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');
		$this->db->where('id_guru', $id_guru);
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_kelas', $id_kelas);
		$this->db->group_by('det_guru_mapel.id_mapel');
		$ambil = $this->db->get('det_guru_mapel');
		$array = $ambil->result_array();
		return $array;
	}
} 


/* End of file MDetailguru.php */
/* Location: ./application/models/MDetailguru.php */
?>