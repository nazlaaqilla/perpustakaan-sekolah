<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_rak_penyimpanan extends CI_Controller
{

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('SubRakPenyimpananModel', 'sub_rak_penyimpanan_model');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_sub_rak_penyimpanan'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('sub_rak_penyimpanan/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->sub_rak_penyimpanan_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['nama_kategori'] = $field->nama_kategori;
				$row['kode_rak'] = $field->kode_rak;
				$row['nama_rak'] = $field->nama_rak;
				$row['nama_sub_rak'] = $field->nama_sub_rak;
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(`' . $field->id_sub_rak . '`)" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(`' . $field->id_sub_rak . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->sub_rak_penyimpanan_model->count_all(),
				"recordsFiltered" => $this->sub_rak_penyimpanan_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$data['listRak'] = $this->db->select('rak_penyimpanan.*, kategori_buku.nama_kategori')
			->from('rak_penyimpanan')
			->join('kategori_buku', 'rak_penyimpanan.id_kategori_buku = kategori_buku.id_kategori_buku')
			->get()
			->result_array();
		$this->load->view('sub_rak_penyimpanan/tambah', $data);
	}

	public function modal_ubah()
	{
		$id_sub_rak = $this->input->post('id_sub_rak');
		$data['data'] = $this->sub_rak_penyimpanan_model->findOne($id_sub_rak);
		$data['listRak'] = $this->db->select('rak_penyimpanan.*, kategori_buku.nama_kategori')
			->from('rak_penyimpanan')
			->join('kategori_buku', 'rak_penyimpanan.id_kategori_buku = kategori_buku.id_kategori_buku')
			->get()
			->result_array();
		$this->load->view('sub_rak_penyimpanan/ubah', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('kode_rak', 'kode_rak', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama_sub_rak', 'nama_sub_rak', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['kode_rak'] = $this->input->post('kode_rak');
			$data['nama_sub_rak'] = $this->input->post('nama_sub_rak');
			$data['created_by'] = $this->session->userdata('id_admin');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->sub_rak_penyimpanan_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'kode_rak_error' => form_error('kode_rak'),
				'nama_sub_rak_error' => form_error('nama_sub_rak')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('id_sub_rak', 'id_sub_rak', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('kode_rak', 'kode_rak', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama_sub_rak', 'nama_sub_rak', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['id_sub_rak'] = $this->input->post('id_sub_rak');
			$data['kode_rak'] = $this->input->post('kode_rak');
			$data['nama_sub_rak'] = $this->input->post('nama_sub_rak');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->sub_rak_penyimpanan_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'kode_rak_error' => form_error('kode_rak'),
				'nama_sub_rak_error' => form_error('nama_sub_rak')
			]);
		}
	}

	public function hapus()
	{
		$data['id_sub_rak'] = $this->input->post('id_sub_rak');
		echo json_encode($this->sub_rak_penyimpanan_model->hapus($data));
	}

	public function getSubRakPenyimpanan()
	{
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->db->get_where('sub_rak_penyimpanan', [
				'kode_rak' => $this->input->post('kode_rak')
			])->result_array());
		}
	}
}
