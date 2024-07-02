<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenjang extends CI_Controller
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
		$this->load->model('JenjangModel', 'jenjang_model');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_jenjang'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('jenjang/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->jenjang_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['nama_jenjang'] = $field->nama_jenjang;
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(' . $field->id_jenjang . ')" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(' . $field->id_jenjang . ')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->jenjang_model->count_all(),
				"recordsFiltered" => $this->jenjang_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$this->load->view('jenjang/tambah');
	}

	public function modal_ubah()
	{
		$id_jenjang = $this->input->post('id_jenjang');
		$data['data'] = $this->jenjang_model->findOne($id_jenjang);
		$this->load->view('jenjang/ubah', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama_jenjang', 'nama_jenjang', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['nama_jenjang'] = $this->input->post('nama_jenjang');
			$data['created_by'] = $this->session->userdata('id_admin');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->jenjang_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_jenjang_error' => form_error('nama_jenjang')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('id_jenjang', 'id_jenjang', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama_jenjang', 'nama_jenjang', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['id_jenjang'] = $this->input->post('id_jenjang');
			$data['nama_jenjang'] = $this->input->post('nama_jenjang');
			$data['updated_by'] = $this->session->userdata('id_admin');
			echo json_encode($this->jenjang_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_jenjang_error' => form_error('nama_jenjang')
			]);
		}
	}

	public function hapus()
	{
		$data['id_jenjang'] = $this->input->post('id_jenjang');
		echo json_encode($this->jenjang_model->hapus($data));
	}
}
