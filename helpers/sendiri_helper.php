<?php 

function nama_admin()
{
	$CI =& get_instance();
	$data = $CI->session->userdata('admin');
	return $data['nama_admin'];
}

function nama_guru()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	$data = $CI->session->userdata('guru');
	return $data['nama_guru'];
}

function nama_kepsek()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	//mengambil data dari db
	$data = $CI->session->userdata('kepala_sekolah');
	return $data['nama_kepala_sekolah'];
}

function nama_ortu()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	//mengambil data dari db
	$data = $CI->session->userdata('ortu');
	return $data['nama_ortu'];
}

function foto_guru()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	$data = $CI->session->userdata('guru');
	return $data['foto_guru'];
}

function foto_siswa()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	$data = $CI->session->userdata('siswa');
	return $data['foto_siswa'];
}

function nama_siswa()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	$data = $CI->session->userdata('siswa');
	return $data['nama_siswa'];
}

function nama_anak()
{
	//panggil fungsi get_instance untuk mendapatkan manfaat dari semua fungsi fungsi ci
	$CI =& get_instance();
	$data = $CI->session->userdata('ortu');
	$id_siswa = $data['id_siswa'];
	$CI->load->model("MSiswa");
	$data_anak = $CI->MSiswa->detail($id_siswa);
	return $data_anak['nama_siswa'];
}

function tahun_ajaran()
{
	$CI =& get_instance();
	$CI->load->model("MTahun");
	$data_tahun = $CI->MTahun->tampil();
	return $data_tahun;
}

function tahun_aktif()
{
	$CI =& get_instance();
	$data = $CI->session->userdata('tahun_ajaran');
	return $data['id_tahun_ajaran'];
}

function tanggal_indonesia($tanggal)
{
	//memecah tanggal berdasarkan tanda -
	$array_tanggal = explode("-", $tanggal);
	//membuat bulan indoneia
	$bulan['01'] = 'Januari';
	$bulan['02'] = 'Februari';
	$bulan['03'] = 'Maret';
	$bulan['04'] = 'April';
	$bulan['05'] = 'Mei';
	$bulan['06'] = 'Juni';
	$bulan['07'] = 'Juli';
	$bulan['08'] = 'Agustus';
	$bulan['09'] = 'September';
	$bulan['10'] = 'Oktober';
	$bulan['11'] = 'November';
	$bulan['12'] = 'Desember';
	//menyusun tanggal menjadi bentuk indonesia
	$indonesia = $array_tanggal[2]." ".$bulan[$array_tanggal[1]]." ".$array_tanggal[0];
	return $indonesia;
}

function isi_pengaturan($id_pengaturan)
{
	$CI =& get_instance();
	$CI->db->where('id_pengaturan', $id_pengaturan);
	$ambil = $CI->db->get("pengaturan");
	$array = $ambil->row_array();
	return $array['isi_pengaturan'];
}

function foto_pengaturan($id_pengaturan)
{
	$CI =& get_instance();
	$CI->db->where('id_pengaturan', $id_pengaturan);
	$ambil = $CI->db->get("pengaturan");
	$array = $ambil->row_array();
	return $array['foto_pengaturan'];
}

function sikap_deskripsi($keterangan_sikap)
{
	if ($keterangan_sikap=="Baik") {
		return isi_pengaturan(4);
	} elseif ($keterangan_sikap=="Cukup"){
		return isi_pengaturan(5);
	} elseif ($keterangan_sikap=="Kurang") {
		return isi_pengaturan(6);
	}
}

function konversi_nilai($nilai)
{
	if ($nilai > 80) {
		return "A";
	} elseif ($nilai > 65) {
		return "B";
	} elseif ($nilai > 50) {
		return "C";
	} else {
		return "D";
	}
}

function deskripsi_nilai($nilai, $id_mapel)
{
	$CI =& get_instance();
	$CI->load->model("MMapel");
	$data_mapel = $CI->MMapel->detail($id_mapel);
	if ($nilai > 80) {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang sangat baik dalam mata pelajaran ".$data_mapel['nama_mapel'];
	} elseif ($nilai > 65) {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang baik dalam mata pelajaran ".$data_mapel['nama_mapel'];
	} elseif ($nilai > 50) {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang cukup dalam mata pelajaran ".$data_mapel['nama_mapel'];
	} else {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang kurang dalam mata pelajaran ".$data_mapel['nama_mapel'];
	}
}

function deskripsi_ekstra($nilai, $id_ekstra)
{
	$CI =& get_instance();
	$CI->load->model("MEkstra");
	$data_ekstra = $CI->MEkstra->detail($id_ekstra);
	if ($nilai == 'Sangat Baik') {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang sangat baik dalam kegiatan ekstrakurikuer ".$data_ekstra['nama_ekstra'];
	} elseif ($nilai == 'Baik') {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang baik dalam kegiatan ekstrakurikuer ".$data_ekstra['nama_ekstra'];
	} elseif ($nilai == 'Cukup') {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang cukup dalam kegiatan ekstrakurikuer ".$data_ekstra['nama_ekstra'];
	} else {
		return "Memiliki kemampuan penguasaan pengetahuan materi yang kurang dalam kegiatan ekstrakurikuer ".$data_ekstra['nama_ekstra'];
	}
}

function deskripsi_kelompok($kelompok)
{
	if ($kelompok=="A") {
		return "Kelompok (A) Umum";
	} elseif ($kelompok=="B") {
		return "Kelompok (B) Umum";
	} elseif ($kelompok=="C") {
		return "Kelompok (C) Peminatan";
	}
}

function deskripsi_peminatan($id_jurusan)
{
	$CI =& get_instance();
	$CI->load->model('MJurusan');
	$data_jurusan = $CI->MJurusan->detail($id_jurusan);
	if ($data_jurusan["nama_jurusan"]=="IPA") {
		return "Peminatan Matematika dan Ilmu Pengetahuan Alam";
	} elseif ($data_jurusan["nama_jurusan"]=="IPS") {
		return "Peminatan Ilmu Pengetahuan Sosial";
	}
}
?>
