<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class MAbsensi extends CI_Model
{
	
	public function cek($id_semester, $tanggal_absensi, $id_siswa_kelas)	
	{
		$this->db->where('id_semester', $id_semester);
		$this->db->where('tanggal_absensi', $tanggal_absensi);
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$ambil = $this->db->get('absensi');
		$array = $ambil->row_array();
		return $array;
	}


	public function simpan($id_semester, $tanggal_absensi, $inputan)
	{
		foreach ($inputan['status_absensi'] as $key => $value) {
			$cek = $this->cek($id_semester, $tanggal_absensi, $key);
			if(empty($cek)){
				$data_tambah['id_semester'] = $id_semester;
				$data_tambah['tanggal_absensi'] = $tanggal_absensi;
				$data_tambah['id_siswa_kelas'] = $key;
				$data_tambah['status_absensi'] = $value;
				$this->db->insert('absensi', $data_tambah);
			}else{
				$data_ubah['status_absensi'] = $value;
				$this->db->where('id_absensi', $cek['id_absensi']);
				$this->db->update('absensi', $data_ubah);
			}
		}
	}

	public function tampil($tanggal_absensi)
	{
		//untuk pengenalan data
		$data = array();
		$this->db->where('tanggal_absensi', $tanggal_absensi);
		$ambil = $this->db->get('absensi');
		$array = $ambil->result_array();
		//untuk mengganti index jadi siswakelas
		foreach ($array as $key => $value) {
			$data[$value['id_siswa_kelas']] = $value;
		}
		return $data;
	}

	public function siswa_absensi($id_tahun_ajaran, $id_semester, $id_siswa)
	{
		$this->db->join('siswa_kelas', 'siswa_kelas.id_siswa_kelas = absensi.id_siswa_kelas');
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa', $id_siswa);
		$ambil = $this->db->get('absensi');
		$array = $ambil->result_array();
		// echo "<pre>";
		// print_r ($array);
		// echo "</pre>";
		return $array;
	}

	public function tampil_rapor($id_tahun_ajaran, $id_siswa, $id_semester)
	{
		$status_absensi = array("Sakit", "Ijin", "Alpa");
		foreach ($status_absensi as $key => $value) {
			$ambil = $this->db->query("SELECT COUNT(id_absensi) as jumlah FROM absensi JOIN siswa_kelas ON siswa_kelas.id_siswa_kelas = absensi.id_siswa_kelas WHERE id_tahun_ajaran='$id_tahun_ajaran' AND id_siswa='$id_siswa' AND id_semester='$id_semester' AND status_absensi='$value'");
			$array = $ambil->row_array();
			$data[$value] = $array['jumlah'];
		}
		return $data;
	}

	public function akumulasi_absensi($id_tahun_ajaran, $id_siswa, $id_semester)
	{
		$status_absensi = array("Sakit", "Ijin", "Alpa");
		foreach ($status_absensi as $key => $value) {
			$ambil = $this->db->query("SELECT COUNT(id_absensi) as jumlah FROM absensi JOIN siswa_kelas ON siswa_kelas.id_siswa_kelas = absensi.id_siswa_kelas WHERE id_tahun_ajaran='$id_tahun_ajaran' AND id_siswa='$id_siswa' AND id_semester='$id_semester' AND status_absensi='$value'");
			$array = $ambil->row_array();
			$data[$value] = $array['jumlah'];
		}
		return $data;
	}
}

/* End of file MAbsensi.php */
/* Location: ./application/models/MAbsensi.php */

 ?>