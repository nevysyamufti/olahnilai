<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('MLogin');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_akun', 'Id akun', 'required');
		$this->form_validation->set_rules('kata_sandi', 'Kata sandi', 'required');
		$this->form_validation->set_message('required', '%s Tidak boleh kosong');
		if ($this->form_validation->run() == TRUE) {
			$inputan = $this->input->post();
			$hasil = $this->MLogin->login($inputan);
			if ($hasil=="admin") {
				redirect('admin','refresh');
			} elseif ($hasil=="kepala_sekolah") {
				redirect('kepsek','refresh');
			} elseif ($hasil=="guru") {
				redirect('guru','refresh');
			} elseif ($hasil=="siswa") {
				redirect('siswa','refresh');
			} elseif ($hasil=="ortu") {
				redirect('ortu','refresh');
			} else {
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger">Gagal Login - Periksa kembali Username/Email dan Password Anda</div>');
			}
		}
		$this->load->view('login');
	}
}