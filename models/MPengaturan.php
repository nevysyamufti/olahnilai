<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MPengaturan extends CI_Model
{
	
	public function tampil()
	{
		$ambil = $this->db->get('pengaturan');
		$array = $ambil->result_array();
		return $array;
	}

	public function tambah($inputan)
	{
		$config['upload_path'] = './assets/img/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$mengupload = $this->upload->do_upload('foto_pengaturan');
		if ($mengupload) {
			$inputan['foto_pengaturan'] = $this->upload->data("file_name");
		}

		$this->db->insert('pengaturan', $inputan);
	}

	public function detail($id_pengaturan)
	{
		$this->db->where('id_pengaturan', $id_pengaturan);
		$ambil = $this->db->get('pengaturan');
		$array = $ambil->row_array();
		return $array;
	}

	public function ubah($inputan, $id_pengaturan)
	{
		$this->db->where('id_pengaturan', $id_pengaturan);
		$this->db->update('pengaturan', $inputan);
	}

	public function hapus($id_pengaturan)
	{
		$this->db->where('id_pengaturan', $id_pengaturan);
		$this->db->delete('pengaturan');
	}

	public function ubah_kenaikan($inputan)
	{
		$data['isi_pengaturan'] = $inputan['mulai']." sd ".$inputan['selesai'];
		$this->db->where('id_pengaturan', 7);
		$this->db->update('pengaturan', $data);
	}
}


/* End of file MPengaturan.php */
/* Location: ./application/models/MPengaturan.php */
 ?>