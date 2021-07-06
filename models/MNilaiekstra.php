 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MNilaiekstra extends CI_Model {

	public function cek($id_semester, $id_siswa_kelas)
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$ambil = $this->db->get('nilai_ekstra');
		$array = $ambil->result_array();
		return $array;
	}

	public function tampil_rapor($id_siswa_kelas, $id_semester)
	{
		$this->db->join('ekstra', 'ekstra.id_ekstra = nilai_ekstra.id_ekstra');
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('nilai_ekstra');
		$array = $ambil->result_array();
		return $array;
	}

	public function simpan($id_semester, $inputan)
	{
		foreach ($inputan['id_ekstra'] as $isk => $data_baru) {
			$data_lama = $this->cek($id_semester, $isk);
			if (empty($data_lama)) {
				//tambah
				foreach ($data_baru as $id_ekstra => $value) {
					$input_tambah['id_siswa_kelas'] = $isk;
					$input_tambah['id_semester'] = $id_semester;
					$input_tambah['id_ekstra'] = $id_ekstra;
					$input_tambah['predikat_nilai_ekstra'] = $inputan['predikat_nilai_ekstra'][$isk][$id_ekstra];
					$this->db->insert('nilai_ekstra', $input_tambah);
				}
			}else{
				//tambah + hapus
				//menyimpan array untuk data ekstra lama yang nntinya akan dibandingkan
				foreach ($data_lama as $key_dl => $value_dl) {
					$ekstra_lama[$isk][$key_dl] = $value_dl['id_ekstra'];
				}
				//menyimpan array untuk data ekstra baru yang nantinya akan dibandingkan
				foreach ($inputan['id_ekstra'][$isk] as $key_db => $value_db) {
					$ekstra_baru[$isk][$key_db] = $key_db;
				}
				//membanding dengan fungsi array_diff
				//hasil array diff adalah mengembalikan data pembandinng didepan yang beda
				$hapus[$isk] = array_diff($ekstra_lama[$isk], $ekstra_baru[$isk]);
				$tambah[$isk] = array_diff($ekstra_baru[$isk], $ekstra_lama[$isk]);
				if (!empty($tambah[$isk])) {
					foreach ($tambah[$isk] as $key_tambah => $id_ekstra) {
						$input_tambah['id_siswa_kelas'] = $isk;
						$input_tambah['id_semester'] = $id_semester;
						$input_tambah['id_ekstra'] = $id_ekstra;
						$input_tambah['predikat_nilai_ekstra'] = $inputan['predikat_nilai_ekstra'][$isk][$id_ekstra];
						$this->db->insert('nilai_ekstra', $input_tambah);
					}
				}
				if (!empty($hapus[$isk])) {
					foreach ($hapus[$isk] as $key_hapus => $id_ekstra) {
						$this->db->where('id_siswa_kelas', $isk);
						$this->db->where('id_semester', $id_semester);
						$this->db->where('id_ekstra', $id_ekstra);
						$this->db->delete('nilai_ekstra');
					}
				}
			}
		}
	}

	function tampil($id_tahun_ajaran, $id_kelas, $id_semester)
	{
		$data = array();
		$this->db->join('siswa_kelas', 'siswa_kelas.id_siswa_kelas = nilai_ekstra.id_siswa_kelas');
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_kelas', $id_kelas);
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('nilai_ekstra');
		$array = $ambil->result_array();
		foreach ($array as $key => $value) {
			$data[$value['id_siswa_kelas']][$value['id_ekstra']] = $value;
		}
		return $data;
	}

}

/* End of file MNilaiekstra.php */
/* Location: ./application/models/MNilaiekstra.php */