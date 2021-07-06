 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MNilai extends CI_Model
{
	
	public function cek($id_det_guru_mapel, $id_siswa, $id_semester)
	{
		$this->db->where('id_det_guru_mapel', $id_det_guru_mapel);
		$this->db->where('id_siswa', $id_siswa);
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('nilai');
		$array = $ambil->row_array();
		return $array;
	}

	public function simpan($inputan, $id_det_guru_mapel, $id_semester)
	{
		foreach ($inputan['nilai'] as $id_siswa => $value) {
			$cek = $this->cek($id_det_guru_mapel, $id_siswa, $id_semester);
			if (empty($cek)) {
				//tambah data
				$tambah['id_det_guru_mapel'] = $id_det_guru_mapel;
				$tambah['id_siswa'] = $id_siswa;
				$tambah['id_semester'] = $id_semester;
				$tambah['nilai_tugas'] = $value['nilai_tugas'];
				$tambah['nilai_uts'] = $value['nilai_uts'];
				$tambah['nilai_uas'] = $value['nilai_uas'];
				$tambah['nilai_praktek'] = $value['nilai_praktek'];
				$this->db->insert('nilai', $tambah);
			} else {
				//ubah data
				$ubah['nilai_tugas'] = $value['nilai_tugas'];
				$ubah['nilai_uts'] = $value['nilai_uts'];
				$ubah['nilai_uas'] = $value['nilai_uas'];
				$ubah['nilai_praktek'] = $value['nilai_praktek'];
				$this->db->where('id_nilai', $cek['id_nilai']);
				$this->db->update('nilai', $ubah);
			}
		}
	}

	public function tampil_nilai($id_det_guru_mapel, $id_semester)
	{
		$data = array();
		$this->db->where('id_det_guru_mapel', $id_det_guru_mapel);
		$this->db->where('id_semester', $id_semester);
		$ambil = $this->db->get('nilai');
		$array = $ambil->result_array();
		foreach ($array as $key => $value) {
			$data[$value['id_siswa']] = $value;
		}
		return $data;
	}

	public function siswa_nilai($id_tahun_ajaran, $id_semester, $id_siswa)
	{
		$data = array();
		$this->db->join('det_guru_mapel', 'det_guru_mapel.id_det_guru_mapel = nilai.id_det_guru_mapel');
		$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');
		$this->db->where('det_guru_mapel.id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa', $id_siswa);
		$ambil = $this->db->get('nilai');
		$array = $ambil->result_array();

		//dari data nilai, tidak ada nilai akhir. krn itu tambahan index nilai akhi dgn cara
		//1. perulangan data nilai
		///nnnnngawurr
		// $data=array();
		foreach ($array as $key => $value) {
			//2. masukkan data nilai di variabel baru
			$data[$key] = $value;
			//3. tmbahkan index baru di variabel baru tersebut
			//lalu hitung nilai berdasarkan rumus
			$data[$key]['nilai_akhir'] = ((($value['nilai_tugas'] + $value['nilai_praktek'])) + $value['nilai_uts'] + $value['nilai_uas']) / 4;
		}
		// echo "<pre>";
		// print_r ($array);
		// echo "</pre>";
		return $data;
	}

	public function siswa_nilai_kelompok($id_tahun_ajaran, $id_semester, $id_siswa)
	{
		//mendapakan jurusan siswa dari:
		//ambil siswa kelas berdasarkan  tahun dari siswa : untuk mendapatkan kelas
		//dari kelas akan mendapatkan jurusan
		$this->db->join('kelas', 'kelas.id_kelas = siswa_kelas.id_kelas');
		$this->db->where('id_tahun_ajaran', $id_tahun_ajaran);
		$this->db->where('id_siswa', $id_siswa);
		$ambil_sk = $this->db->get('siswa_kelas');
		$data_sk = $ambil_sk->row_array();
		$id_jurusan = $data_sk['id_jurusan'];


		//data kelompok
		//mendapatkan mapel kelompok A
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->where('kelompok_mapel', "A");
		$this->db->order_by('urutan_mapel', 'asc');
		$ambil_a = $this->db->get('mapel');
		$array_a = $ambil_a->result_array();
		foreach ($array_a as $key => $value) {
			$data_a["Umum"][$value['id_mapel']] = $value;
		}

		//mendapatkan mapel kelompok B
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->where('kelompok_mapel', "B");
		$this->db->order_by('urutan_mapel', 'asc');
		$ambil_b = $this->db->get('mapel');
		$array_b = $ambil_b->result_array();
		foreach ($array_b as $key => $value) {
			$data_b["Umum"][$value['id_mapel']] = $value;
		}

		//mendapatkan mapel kelompok C
		$this->load->model('MJurusan');
		$data_j = $this->MJurusan->tampil();
		foreach ($data_j as $key => $value) {
			$this->db->where('mapel.id_jurusan', $value['id_jurusan']);
			$this->db->where('kelompok_mapel', "C");
			$this->db->order_by('urutan_mapel', 'asc');
			$ambil_c = $this->db->get('mapel');
			$array_c = $ambil_c->result_array();
			foreach ($array_c as $key => $value) {
				$data_c[$value['id_jurusan']][$value['id_mapel']] = $value;
			}
		}
		//mengabungkan semua mapel
		$data_mapel["A"] = $data_a;
		$data_mapel["B"] = $data_b;
		$data_mapel["C"] = $data_c;

		foreach ($data_mapel as $kelompok => $value_1) {
			foreach ($value_1 as $jurusan => $value_2) {
				foreach ($value_2 as $mapel => $value_3) {
					$this->db->join('det_guru_mapel', 'det_guru_mapel.id_det_guru_mapel = nilai.id_det_guru_mapel');
					$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');
					$this->db->where('det_guru_mapel.id_tahun_ajaran', $id_tahun_ajaran);
					$this->db->where('id_semester', $id_semester);
					$this->db->where('id_siswa', $id_siswa);
					$this->db->where('det_guru_mapel.id_mapel', $mapel);
					$ambil_nilai = $this->db->get('nilai');
					$array_nilai = $ambil_nilai->row_array();
					$data_nilai[$kelompok][$jurusan][$mapel] = $value_3;
					if (!empty($array_nilai)) {
						$nilai_akhir = ((($array_nilai['nilai_tugas'] + $array_nilai['nilai_praktek'])) + $array_nilai['nilai_uts'] + $array_nilai['nilai_uas']) / 4;
						$data_nilai[$kelompok][$jurusan][$mapel]['nilai_akhir'] = $nilai_akhir;
					}else{
						$data_nilai[$kelompok][$jurusan][$mapel]['nilai_akhir'] = "";
					}
				}
			}
		}
		return $data_nilai;
	}

	public function nilai_rata_rata_akhir($id_tahun_ajaran, $id_semester, $id_siswa)
	{
		$data_nilai = $this->siswa_nilai($id_tahun_ajaran, $id_semester, $id_siswa);
		//count adalah fungsi bawaan PHP untuk menghitung jumlah item dr array
		$jumlah_mapel = count($data_nilai);
		$jumlah_nilai = 0;
		foreach ($data_nilai as $key => $value) {
			//menjumlahkan semua nilai akhiir
			$jumlah_nilai += $value['nilai_akhir'];
		}
		//membagi jumlah item
		if ($jumlah_mapel > 0) {
			$rata_rata_akhir = $jumlah_nilai / $jumlah_mapel;
		} else {
			$rata_rata_akhir = 0;
		}
		return $rata_rata_akhir;
	}

	public function grafik($id_siswa)
	{
		$this->db->join('det_guru_mapel', 'det_guru_mapel.id_det_guru_mapel = nilai.id_det_guru_mapel');
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = det_guru_mapel.id_tahun_ajaran');
		$this->db->join('semester', 'semester.id_semester = nilai.id_semester');
		$this->db->where('id_siswa', $id_siswa);
		$ambil = $this->db->get('nilai');
		$array = $ambil->result_array();
		foreach ($array as $key => $value) {
			$ita = $value['id_tahun_ajaran'];
			$is = $value['id_semester'];
			$nta = $value['tahun_ajaran'];
			$ns = $value['nama_semester'];
			$nrra = $this->nilai_rata_rata_akhir($ita, $is, $id_siswa);
			$data['kategori'][$nta] = $nta;
			$data['seri'][$ns][$nta] = $nrra;
		}
		return $data;
	}

	public function semua_siswa_nilai($id_siswa)
	{
		$data = array();
		$this->db->join('det_guru_mapel', 'det_guru_mapel.id_det_guru_mapel = nilai.id_det_guru_mapel');
		$this->db->join('mapel', 'mapel.id_mapel = det_guru_mapel.id_mapel');
		$this->db->join('semester', 'semester.id_semester = nilai.id_semester');
		$this->db->join('tahun_ajaran', 'tahun_ajaran.id_tahun_ajaran = det_guru_mapel.id_tahun_ajaran');
		// // $this->db->where('det_guru_mapel.id_tahun_ajaran', $id_tahun_ajaran);
		// // $this->db->where('id_semester', $id_semester);
		$this->db->where('id_siswa', $id_siswa);
		$ambil = $this->db->get('nilai');
		$array = $ambil->result_array();
		foreach ($array as $key => $value) {
			//2. masukkan data nilai di variabel baru
			$data[$key] = $value;
			//3. tmbahkan index baru di variabel baru tersebut
			//lalu hitung nilai berdasarkan rumus
			$data[$key]['nilai_akhir'] = ((($value['nilai_tugas'] + $value['nilai_praktek'])) + $value['nilai_uts'] + $value['nilai_uas']) / 4;
		}
		// echo "<pre>";
		// print_r ($array);
		// echo "</pre>";
		return $data;
	}

	public function nilai_rata_rata_semua($id_siswa)
	{
		$data_nilai = $this->semua_siswa_nilai($id_siswa);
		//count adalah fungsi bawaan PHP untuk menghitung jumlah item dr array
		$jumlah_mapel = count($data_nilai);
		$jumlah_nilai = 0;
		foreach ($data_nilai as $key => $value) {
			//menjumlahkan semua nilai akhiir
			$jumlah_nilai += $value['nilai_akhir'];
		}
		//membagi jumlah item
		if ($jumlah_mapel > 0 )
		{
			$rata_rata_akhir = $jumlah_nilai / $jumlah_mapel;
		}else{
			$rata_rata_akhir=0;
		}
		return $rata_rata_akhir;
	}

	public function nilai_tugas_tertinggi($id_siswa)
		{
			// $this->semua_siswa_nilai($id_siswa);
			$this->db->where('id_siswa', $id_siswa);
			$this->db->select_max('nilai_tugas', 'max');
			$ambil = $this->db->get('nilai');
			$array = $ambil->row_array();
			return $array;
		}
	// public function nilai_rata_tugas($id_tahun_ajaran, $id_semester, $id_siswa)
	// {
	// 	$data_nilai = $this->siswa_nilai($id_tahun_ajaran, $id_semester, $id_siswa);
	// 	//count adalah fungsi bawaan PHP untuk menghitung jumlah item dr array
	// 	$jumlah_mapel = count($data_nilai);
	// 	$jumlah_nilai = 0;
	// 	foreach ($data_nilai as $key => $value) {
	// 		//menjumlahkan semua nilai akhiir
	// 		$jumlah_uts += $value['nilai_akhir'];
	// 	}
	// 	//membagi jumlah item
	// 	if ($jumlah_mapel > 0) {
	// 		$nilai_rata_tugas = $jumlah_uts / $jumlah_mapel;
	// 	} else {
	// 		$nilai_rata_tugas = 0;
	// 	}
	// 	return $nilai_rata_tugas;
	// }
}


/* End of file MNilai.php */
/* Location: ./application/models/MNilai.php */
?>