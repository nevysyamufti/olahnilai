 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Siswakelas extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		if (!$this->session->userdata("admin")) {
			redirect('','refresh');
		}
		$this->load->model('MSiswakelas');
		$this->load->model('MSiswa');
		$this->load->model('MTahun');
		$this->load->model('MKelas');
		$this->load->model('MSemester');
	}

	public function index()
	{
		$data['tahun_ajaran'] = $this->MTahun->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		//mengubah post menjadi get(mengambil data dari url) post (mendappat  data dr db)
		$inputan = $this->input->get();
		// $inputan = $this->input->post();
		if ($inputan) {
			$data['idt'] = $this->input->get('id_tahun_ajaran');
			$data['idk'] = $this->input->get('id_kelas');
			// $data['idt'] = $this->input->post('id_tahun_ajaran');
			// $data['idk'] = $this->input->post('id_kelas');
		}else{
			$tahun_aktif = $this->MTahun->tahun_aktif();
			$data['idt'] = $tahun_aktif['id_tahun_ajaran'];
			$data['idk'] = $data['kelas'][0]['id_kelas'];
		}
		$data['siswakelas'] = $this->MSiswakelas->tampil_siswa($data['idt'], $data['idk']);
		//untuk memunculkan naik kelals berdasarkan tahun aktif
		$data['tahun_aktif'] = $this->MTahun->tahun_aktif();
		$data['semester_aktif'] = $this->MSemester->semester_aktif();

		//pengaturan periode kenaikan kelas
		$pengaturan = isi_pengaturan(7);
		$explode_pengaturan = explode(" sd ", $pengaturan);
		if (date("Y-m-d") >= $explode_pengaturan[0] AND date("Y-m-d") <= $explode_pengaturan[1]) {
			$data['periode_kenaikan'] = "ya";
		}else{
			$data['periode_kenaikan'] = "tidak";
		}

		$dk = $this->MKelas->detail($data['idk']);
		$array_kelas = explode(" ", $dk['nama_kelas']);
		$tahun_kelas = $array_kelas[0];
		$data["tahun_kelas"] = $tahun_kelas;
		$jurusan_kelas = $array_kelas[1];
		$tingkat_kelas = $dk['tingkat_kelas'];
		if ($tahun_kelas < 12) {
			$cek_kelas = $this->MKelas->cek_kelas(($tahun_kelas+1)." ".$jurusan_kelas, $tingkat_kelas);
			if (!empty($cek_kelas)) {
				$data['id_kelas_selanjutnya'] = $cek_kelas['id_kelas'];
				$data['kelas_selanjutnya'] = "Naik Kelas ".($tahun_kelas+1)." ".$jurusan_kelas." ".$tingkat_kelas;
			}else{
				$data['id_kelas_selanjutnya'] = "Kosong";
				$data['kelas_selanjutnya'] = "Naik Kelas ".($tahun_kelas+1)." ".$jurusan_kelas." ".$tingkat_kelas." (Masih Kosong)";
			}
		}else{
			$data['id_kelas_selanjutnya'] = "";
			$data['kelas_selanjutnya'] = "Luluskan Siswa";
		}

		//checked siswa sudah naik kealas atau belum
		//cek siswa ditahun berikutnya ada dikellas mana
		//jika kelas yang berbed maka naik kelas, selain itu tidak
		$id_tahun_berikutnya = $this->MTahun->tahun_berikutnya($data['idt']);
		foreach ($data['siswakelas'] as $key => $value) {
			$ids = $value['id_siswa'];
			if($tahun_kelas < 12){
				$cek_tahun_berikutnya = $this->MSiswakelas->siswa_tahun($ids, $id_tahun_berikutnya);
				if(!empty($cek_tahun_berikutnya)){
					if ($cek_tahun_berikutnya['id_kelas']==$data['idk']){
						$data['cek_kenaikan'][$ids] = "tidak_naik";
					}else{
						$data['cek_kenaikan'][$ids] = "naik";
					}
				}else{
					$data['cek_kenaikan'][$ids] = "naik";
				}
			}else{
				if($value['status_siswa']=="Lulus" OR $value['status_siswa']=='Aktif'){
					$data['cek_kenaikan'][$ids] = "lulus";	
				}else{
					$data['cek_kenaikan'][$ids] = "tidak_lulus";
				}

			}
		}

		$input_naik_kelas = $this->input->post();
		if ($input_naik_kelas) {
			foreach ($input_naik_kelas['kenaikan'] as $id_siswa => $value) {
				if ($value=="naik") {
					$this->naik_kelas(($data['idt']+1), $data['id_kelas_selanjutnya'], $id_siswa);
				} elseif($value=="tidak_naik") {
					$this->naik_kelas(($data['idt']+1), $data['idk'], $id_siswa);
				} elseif($value=="lulus") {
					$this->ubah_status($id_siswa, 'Lulus');
				} elseif($value=="tidak_lulus") {
					$this->ubah_status($id_siswa, 'Tidak Lulus');
				}
			}
			redirect('admin/siswakelas?id_tahun_ajaran='.($data['idt']+1).'&id_kelas='.$data['id_kelas_selanjutnya'],'refresh');
		}

		$this->load->view('admin/header');
		$this->load->view('admin/siswakelas/tampil', $data);
		$this->load->view('admin/footer');
	}

	public function naik_kelas($id_tahun_ajaran, $id_kelas, $id_siswa)
	{	
		$inputan['id_tahun_ajaran'] = $id_tahun_ajaran;
		$inputan['id_kelas'] = $id_kelas;
		$inputan['id_siswa'] = $id_siswa;
		$this->MSiswakelas->tambah($inputan);
	}
	// public function naik_kelas($id_tahun_ajaran, $id_kelas, $id_siswa)
	// {
	// 	$inputan['id_tahun_ajaran'] = $id_tahun_ajaran;
	// 	$inputan['id_kelas'] = $id_kelas;
	// 	$inputan['id_siswa'] = $id_siswa;
	// 	$this->MSiswakelas->tambah($inputan);
	// 	redirect('admin/siswakelas','refresh');
	// }

	public function tambah()
	{
		$data['siswa'] = $this->MSiswa->siswa_tanpa_kelas();
		$data['tahun_ajaran'] = $this->MTahun->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun Ajaran','required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');

		if($this->form_validation->run()== TRUE){
			$inputan = $this->input->post();
			foreach ($inputan['id_siswa'] as $id_siswa => $ket) {
				$inputan['id_siswa'] = $id_siswa;
				$hasil = $this->MSiswakelas->tambah($inputan);
			}
			redirect('admin/siswakelas','refresh');
		}

		$this->load->view('admin/header');
		$this->load->view('admin/siswakelas/tambah',$data);
		$this->load->view('admin/footer');
	}

	public function ubah($id_siswa_kelas)
	{
		$data['siswa'] = $this->MSiswa->tampil();
		$data['tahun_ajaran'] = $this->MTahun->tampil();
		$data['kelas'] = $this->MKelas->tampil();
		$data['detail'] = $this->MSiswakelas->detail($id_siswa_kelas);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_siswa', 'Nama Siswa', 'required');
		$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun AJaran','required');
		$this->form_validation->set_message('required', '%s tidak boleh kososng');
		

		if ($this->form_validation->run() == TRUE) {
			$inputan = $this->input->post();
			$hasil = $this->MSiswakelas->ubah($inputan, $id_siswa_kelas);
			if($hasil=="sukses"){
				redirect('admin/siswakelas','refresh');
			}else{
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
			}
		}
		$this->load->view('admin/header');
		$this->load->view('admin/siswakelas/ubah', $data);
		$this->load->view('admin/footer');	
	}
	
	public function hapus($id_siswa_kelas)
	{
		$this->MSiswakelas->hapus($id_siswa_kelas);
		redirect('admin/siswakelas','refresh');
	}

	//untuk mengubah status siswa di siswa kelas (saat ada kenaikan kelas/lulus)
	public function ubah_status($id_siswa, $status_siswa)
	{
		$inputan['status_siswa'] = $status_siswa;
		$this->MSiswa->ubah($inputan, $id_siswa);
		redirect('admin/siswakelas','refresh');
	}
}  
	// public function ubah($id_siswa_kelas)
	// {
	// 	$data['siswa'] = $this->MSiswa->tampil();
	// 	$data['tahun_ajaran'] = $this->MTahun->tampil();
	// 	$data['kelas'] = $this->MKelas->tampil();
	// 	$data['detail'] = $this->MSiswakelas->detail($id_siswa_kelas);

	// 	$this->load->library('form_validation');
	// 	$this->form_validation->set_rules('id_siswa', 'Nama Siswa', 'required');
	// 	$this->form_validation->set_rules('id_tahun_ajaran', 'Tahun AJaran','required');
	// 	$this->form_validation->set_message('required', '%s tidak boleh kososng');


	// 	if ($this->form_validation->run() == TRUE) {
	// 		$inputan = $this->input->post();
	// 		$hasil = $this->MSiswakelas->ubah($inputan, $id_siswa_kelas);
	// 		if($hasil=="sukses"){
	// 			redirect('admin/siswakelas','refresh');
	// 		}else{
	// 			$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Data sudah ada. Silahkan input ulang</div>');
	// 		}
	// 	}
	// 	$this->load->view('admin/header');
	// 	$this->load->view('admin/siswakelas/ubah', $data);
	// 	$this->load->view('admin/footer');	
	// }

	// public function hapus($id_siswa_kelas)
	// {
	// 	$this->MSiswakelas->hapus($id_siswa_kelas);
	// 	redirect('admin/siswakelas','refresh');
	// }



/* End of file Siswakelas.php */
/* Location: ./application/controllers/admin/Siswakelas.php */
?>