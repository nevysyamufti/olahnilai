<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MProfil extends CI_Controller {

	// public function ubah($inputan)
	// {
	// 	$config['upload_path'] = './assets/img/siswa/';
	// 	$config['allowed_types'] = 'gif|jpg|png|jpeg';
	// 	$this->load->library('upload', $config);
	// 	$mengupload = $this->upload->do_upload('foto_siswa');
	// 	if ($mengupload){
	// 		$inputan['foto_siswa'] = $this->upload->data('file_name');
	// 		$data_lama = $this->session->userdata('siswa');
	// 		$foto_lama = $data_lama['foto_siswa'];
	// 		if (file_exists("./assets/img/siswa/".$foto_lama)) {
	// 			//jika ada maka hapus foto menggunakan unlink
	// 			unlink("./assets/img/siswa/".$foto_lama);
	// 		}
	// 	}
	// 	$this->db->where('id_siswa', $id_siswa);
	// 	$this->db->update('siswa', $inputan);
	// }		

}

/* End of file MProfil.php */
/* Location: ./application/models/MProfil.php */