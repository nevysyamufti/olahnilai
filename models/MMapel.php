 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MMapel extends CI_Model
{
	
	public function tampil()
	{
		$this->db->join('jurusan', 'jurusan.id_jurusan = mapel.id_jurusan');
		//UNTUK MENGURUTKAN DATA MAPEL dari terkecil
		$this->db->order_by('mapel.id_jurusan', 'asc');
		$this->db->order_by('kelompok_mapel', 'asc');
		$this->db->order_by('urutan_mapel', 'asc');
		$ambil = $this->db->get('mapel');
		$array = $ambil->result_array();
		return $array;
	}

	public function  cek($nama_jurusan, $nama_mapel, $kkm_mapel, $kelompok_mapel, $urutan_mapel)
	{
		$this->db->where('id_jurusan', $nama_jurusan);
		$this->db->where('nama_mapel', $nama_mapel);
		$this->db->where('kkm_mapel', $kkm_mapel);
		//penambahan kelompok dan urutan
		$this->db->where('kelompok_mapel', $kelompok_mapel);
		$this->db->where('urutan_mapel', $urutan_mapel);
		$ambil = $this->db->get('mapel');
		$array = $ambil->row_array();
		return $array;
	} 

	public function tambah($inputan)
	{
		$cek = $this->cek($inputan['id_jurusan'], $inputan['nama_mapel'], $inputan['kkm_mapel'], $inputan['kelompok_mapel'], $inputan['urutan_mapel']);
		if(empty($cek)){
			$this->db->insert('mapel', $inputan);
			return "sukses";
		}
	}
	public function detail($id_mapel)
	{
		$this->db->where('id_mapel', $id_mapel);
		$ambil = $this->db->get('mapel');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_mapel)
	{
		$cek = $this->cek($inputan['id_jurusan'], $inputan['nama_mapel'], $inputan['kkm_mapel'], $inputan['kelompok_mapel'], $inputan['urutan_mapel']);
		if(empty($cek)){
			$this->db->where('id_mapel', $id_mapel);
			$this->db->update('mapel', $inputan);
			return "sukses";
		}
	}

	public function hapus($id_mapel)
	{
		$this->db->where('id_mapel', $id_mapel);
		$this->db->delete('mapel');
	}
}


/* End of file MMapel.php */
/* Location: ./application/models/MMapel.php */
?>