<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MSiswakelas extends CI_Model
{
	public function tampil() 
	{
		$this->db->join('siswa', 'siswa.id_siswa = siswa_kelas.id_siswa');
		
		//untuk mrmunculkan nama kelas
		$this->db->join('kelas', 'kelas.id_kelas = siswa_kelas.id_kelas');
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = siswa_kelas.id_tahun_ajaran');
		//untuk memunculkan nama guru
		$ambil = $this->db->get('siswa_kelas');
		$array = $ambil->result_array();
		
		//mengambil dan menggabungkan
		foreach ($array as $key => $value) {
			$this->db->join('guru', 'wali_kelas.id_guru = guru.id_guru');
			$this->db->where('id_tahun_ajaran', $value['id_tahun_ajaran']);
			$this->db->where('id_kelas', $value['id_kelas']);
			$ambil_wali = $this->db->get('wali_kelas');
			$array_wali = $ambil_wali->row_array();
			$data[$key] = $value;
			$data[$key]['nama_guru'] = $array_wali['nama_guru'];
		}
		return $data;
	}

	public function cek($id_siswa, $id_tahun_ajaran, $id_kelas)
	{
		$this->db->where('id_siswa', $id_siswa);
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_kelas', $id_kelas);

		$ambil = $this->db->get('siswa_kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function tambah($inputan)
	{
		//untuk menambahkan siswa naik kelas pertahunnya
		$cek =  $this->siswa_tahun($inputan['id_siswa'], $inputan['id_tahun_ajaran']);
		//jika kosong maka akan ditambah
		if(empty($cek)){
			$this->db->insert('siswa_kelas', $inputan);
			return "sukses";
			//jika tdk maka, dicek apa benar siswa itu, jika iya maka akan diupdate berdasarkan id siswa, sesuai tahun ajaran
		} else {
			$this->db->where('id_siswa_kelas', $cek['id_siswa_kelas']);
			$this->db->update('siswa_kelas', $inputan);
		}
	}

	public function detail($id_siswa_kelas)
	{
		$this->db->join('siswa', 'siswa.id_siswa = siswa_kelas.id_siswa');
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$ambil = $this->db->get('siswa_kelas');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_siswa_kelas)
	{
		$cek =  $this->cek($inputan['id_siswa'], $inputan['id_tahun_ajaran'], $inputan['id_kelas']);
		if(empty($cek)){
			$this->db->where('id_siswa_kelas', $id_siswa_kelas);
			$this->db->update('siswa_kelas', $inputan);
			return "sukses";
		}
	}

	public function hapus($id_siswa_kelas)
	{
		$this->db->where('id_siswa_kelas', $id_siswa_kelas);
		$this->db->delete('siswa_kelas');
	}

	public function tampil_siswa($id_tahun_ajaran, $id_kelas)
	{
		$data=array();
		$this->db->join('siswa', 'siswa.id_siswa = siswa_kelas.id_siswa');
		$this->db->join('kelas', 'kelas.id_kelas = siswa_kelas.id_kelas');
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = siswa_kelas.id_tahun_ajaran');
		$this->db->where('siswa_kelas.id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('siswa_kelas.id_kelas', $id_kelas);
		$ambil = $this->db->get('siswa_kelas');
		$array = $ambil->result_array();
		//mengambil dan menggabungkan
		foreach ($array as $key => $value) {
			$this->db->join('guru', 'wali_kelas.id_guru = guru.id_guru');
			$this->db->where('id_tahun_ajaran', $value['id_tahun_ajaran']);
			$this->db->where('id_kelas', $value['id_kelas']);
			$ambil_wali = $this->db->get('wali_kelas');
			$array_wali = $ambil_wali->row_array();
			$data[$key] = $value;
			if(!empty($array_wali)){
				$data[$key]['nama_guru'] = $array_wali['nama_guru'];
			}else{
				$data[$key]['nama_guru'] = "";
			}
		}
		return $data;
	}

	public function siswa_tahun($id_siswa, $id_tahun_ajaran)
	{
		$this->db->where('id_siswa', $id_siswa);
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->join('kelas', 'kelas.id_kelas = siswa_kelas.id_kelas');
		$ambil = $this->db->get('siswa_kelas');
		$array = $ambil->row_array();
		return $array;
	}	
} 


/* End of file MSiswakelas.php */
/* Location: ./application/models/MSiswakelas.php */
?>