<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
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
		$this->load->model('KategoriModel', 'kategori_model');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_kategori_buku'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('kategori/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->kategori_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['nama_kategori'] = $field->nama_kategori;
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(' . $field->id_kategori_buku . ')" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(' . $field->id_kategori_buku . ')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->kategori_model->count_all(),
				"recordsFiltered" => $this->kategori_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$this->load->view('kategori/tambah');
	}

	public function modal_ubah()
	{
		$id_kategori_buku = $this->input->post('id_kategori_buku');
		$data['data'] = $this->kategori_model->findOne($id_kategori_buku);
		$this->load->view('kategori/ubah', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama_kategori', 'nama_kategori', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['nama_kategori'] = $this->input->post('nama_kategori');
			$data['created_by'] = $this->session->userdata('id_admin');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->kategori_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_kategori_error' => form_error('nama_kategori')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('id_kategori_buku', 'id_kategori_buku', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama_kategori', 'nama_kategori', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['id_kategori_buku'] = $this->input->post('id_kategori_buku');
			$data['nama_kategori'] = $this->input->post('nama_kategori');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->kategori_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_kategori_error' => form_error('nama_kategori')
			]);
		}
	}

	public function hapus()
	{
		$data['id_kategori_buku'] = $this->input->post('id_kategori_buku');
		echo json_encode($this->kategori_model->hapus($data));
	}
}
