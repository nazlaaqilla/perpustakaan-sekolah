<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
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
		$this->load->model('SiswaModel', 'siswa_model');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_siswa'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('siswa/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->siswa_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['nisn'] = $field->nisn;
				$row['nama'] = $field->nama;
				$row['nama_jenjang'] = $field->nama_jenjang;
				$row['nomor_ponsel'] = $field->nomor_ponsel;
				$row['alamat'] = $field->alamat;
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(`' . $field->nisn . '`)" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(`' . $field->nisn . '`)" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->siswa_model->count_all(),
				"recordsFiltered" => $this->siswa_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$data['listJenjang'] = $this->db->get('jenjang')->result_array();
		$this->load->view('siswa/tambah', $data);
	}

	public function modal_ubah()
	{
		$nisn = $this->input->post('nisn');
		$data['data'] = $this->siswa_model->findOne($nisn);
		$data['listJenjang'] = $this->db->get('jenjang')->result_array();
		$this->load->view('siswa/ubah', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nisn', 'nisn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama', 'nama', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('id_jenjang', 'jenjang', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('nomor_ponsel', 'nomor_ponsel', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('alamat', 'alamat', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['nisn'] = $this->input->post('nisn');
			$data['nama'] = $this->input->post('nama');
			$data['id_jenjang'] = $this->input->post('id_jenjang');
			$data['nomor_ponsel'] = $this->input->post('nomor_ponsel');
			$data['alamat'] = $this->input->post('alamat');
			$data['created_by'] = $this->session->userdata('id_admin');
			$data['updated_by'] = $this->session->userdata('id_admin');

			if ($_FILES['gambar']['name'] != '') {
				$config['upload_path']          = 'assets/image/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
				$config['max_size']             = 1024;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					echo json_encode([
						'status' => false,
						'message' => 'Terdapat error pada pengisian form!',
						'nisn_error' => form_error('nisn'),
						'nama_error' => form_error('nama'),
						'id_jenjang_error' => form_error('id_jenjang'),
						'gambar_error' => $this->upload->display_errors(),
						'nomor_ponsel_error' => form_error('nomor_ponsel'),
						'alamat_error' => form_error('alamat')
					]);
					die;
				} else {
					$data['gambar'] = $this->upload->data('file_name');
				}
			}

			echo json_encode($this->siswa_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_error' => form_error('nama'),
				'id_jenjang_error' => form_error('id_jenjang'),
				'gambar_error' => '',
				'nomor_ponsel_error' => form_error('nomor_ponsel'),
				'alamat_error' => form_error('alamat')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('nisn_lama', 'nisn_lama', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nisn', 'nisn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama', 'nama', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('id_jenjang', 'jenjang', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('nomor_ponsel', 'nomor_ponsel', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('alamat', 'alamat', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['nisn'] = $this->input->post('nisn_lama');
			$data['nisn'] = $this->input->post('nisn');
			$data['nama'] = $this->input->post('nama');
			$data['id_jenjang'] = $this->input->post('id_jenjang');
			$data['nomor_ponsel'] = $this->input->post('nomor_ponsel');
			$data['alamat'] = $this->input->post('alamat');
			$data['updated_by'] = $this->session->userdata('id_admin');

			$dataExist = $this->db->get_where('siswa', [
				'nisn' => $where['nisn']
			])->row_array();

			if ($dataExist != null && $data['nisn'] != $where['nisn']) {
				echo json_encode([
					'status' => false,
					'message' => 'Terdapat error pada pengisian form!',
					'nisn_error' => 'The nisn field must contain a unique value',
					'nama_error' => form_error('nama'),
					'id_jenjang_error' => form_error('id_jenjang'),
					'gambar_error' => '',
					'nomor_ponsel_error' => form_error('nomor_ponsel'),
					'alamat_error' => form_error('alamat')
				]);
				die;
			}

			if ($_FILES['gambar']['name'] != '') {
				$config['upload_path']          = 'assets/image/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
				$config['max_size']             = 1024;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					echo json_encode([
						'status' => false,
						'message' => 'Terdapat error pada pengisian form!',
						'nisn_error' => form_error('nisn'),
						'nama_error' => form_error('nama'),
						'id_jenjang_error' => form_error('id_jenjang'),
						'gambar_error' => $this->upload->display_errors(),
						'nomor_ponsel_error' => form_error('nomor_ponsel'),
						'alamat_error' => form_error('alamat')
					]);
					die;
				} else {
					$data['gambar'] = $this->upload->data('file_name');
				}
			}

			echo json_encode($this->siswa_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nisn_error' => form_error('nisn'),
				'nama_error' => form_error('nama'),
				'id_jenjang_error' => form_error('id_jenjang'),
				'password_error' => form_error('password'),
				'gambar_error' => '',
				'nomor_ponsel_error' => form_error('nomor_ponsel'),
				'alamat_error' => form_error('alamat')
			]);
		}
	}

	public function hapus()
	{
		$data['nisn'] = $this->input->post('nisn');
		echo json_encode($this->siswa_model->hapus($data));
	}
}
