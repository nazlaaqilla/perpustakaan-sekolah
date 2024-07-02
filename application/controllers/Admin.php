<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
		$this->load->model('AdminModel', 'admin_model');
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('admin/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->admin_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['email'] = $field->email;
				$row['nama'] = $field->nama;
				$row['aksi'] = $field->is_superadmin != 1 ? '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(' . $field->id_admin . ')" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(' . $field->id_admin . ')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>' : '';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->admin_model->count_all(),
				"recordsFiltered" => $this->admin_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$this->load->view('admin/tambah');
	}

	public function modal_ubah()
	{
		$id_admin = $this->input->post('id_admin');
		$data['data'] = $this->admin_model->findOne($id_admin);
		$this->load->view('admin/ubah', $data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'nama', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('email', 'email', 'required|trim|htmlspecialchars|is_unique[login.email]');
		$this->form_validation->set_rules('password', 'password', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('permission_buku', 'permission_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_kategori_buku', 'permission_kategori_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_peminjaman_buku', 'permission_peminjaman_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_penyimpanan_buku', 'permission_penyimpanan_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_klasifikasi', 'permission_klasifikasi', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_jenjang', 'permission_jenjang', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_siswa', 'permission_siswa', 'required|trim|in_list[0,1]|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['nama'] = $this->input->post('nama');
			$data['email'] = $this->input->post('email');
			$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			$data['permission_buku'] = $this->input->post('permission_buku');
			$data['permission_kategori_buku'] = $this->input->post('permission_kategori_buku');
			$data['permission_peminjaman_buku'] = $this->input->post('permission_peminjaman_buku');
			$data['permission_penyimpanan_buku'] = $this->input->post('permission_penyimpanan_buku');
			$data['permission_klasifikasi'] = $this->input->post('permission_klasifikasi');
			$data['permission_jenjang'] = $this->input->post('permission_jenjang');
			$data['permission_siswa'] = $this->input->post('permission_siswa');

			if ($_FILES['gambar']['name'] != '') {
				$config['upload_path']          = 'assets/image/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
				$config['max_size']             = 1024;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					echo json_encode([
						'status' => false,
						'message' => 'Terdapat error pada pengisian form!',
						'nama_error' => form_error('nama'),
						'email_error' => form_error('email'),
						'password_error' => form_error('password'),
						'gambar_error' => $this->upload->display_errors(),
						'permission_buku' => form_error('permission_buku'),
						'permission_kategori_buku' => form_error('permission_kategori_buku'),
						'permission_peminjaman_buku' => form_error('permission_peminjaman_buku'),
						'permission_penyimpanan_buku' => form_error('permission_penyimpanan_buku'),
						'permission_klasifikasi' => form_error('permission_klasifikasi'),
						'permission_siswa' => form_error('permission_siswa')
					]);
					die;
				} else {
					$data['gambar'] = $this->upload->data('file_name');
				}
			}

			echo json_encode($this->admin_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_error' => form_error('nama'),
				'email_error' => form_error('email'),
				'password_error' => form_error('password'),
				'gambar_error' => '',
				'permission_buku' => form_error('permission_buku'),
				'permission_kategori_buku' => form_error('permission_kategori_buku'),
				'permission_peminjaman_buku' => form_error('permission_peminjaman_buku'),
				'permission_penyimpanan_buku' => form_error('permission_penyimpanan_buku'),
				'permission_klasifikasi' => form_error('permission_klasifikasi'),
				'permission_jenjang' => form_error('permission_jenjang'),
				'permission_siswa' => form_error('permission_siswa')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('id_admin', 'id_admin', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nama', 'nama', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('email', 'email', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('password', 'password', 'trim|htmlspecialchars');
		$this->form_validation->set_rules('permission_buku', 'permission_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_kategori_buku', 'permission_kategori_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_peminjaman_buku', 'permission_peminjaman_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_penyimpanan_buku', 'permission_penyimpanan_buku', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_klasifikasi', 'permission_klasifikasi', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_jenjang', 'permission_jenjang', 'required|trim|in_list[0,1]|htmlspecialchars');
		$this->form_validation->set_rules('permission_siswa', 'permission_siswa', 'required|trim|in_list[0,1]|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['id_admin'] = $this->input->post('id_admin');
			$data['nama'] = $this->input->post('nama');
			$data['email'] = $this->input->post('email');
			$data['permission_buku'] = $this->input->post('permission_buku');
			$data['permission_kategori_buku'] = $this->input->post('permission_kategori_buku');
			$data['permission_peminjaman_buku'] = $this->input->post('permission_peminjaman_buku');
			$data['permission_penyimpanan_buku'] = $this->input->post('permission_penyimpanan_buku');
			$data['permission_klasifikasi'] = $this->input->post('permission_klasifikasi');
			$data['permission_jenjang'] = $this->input->post('permission_jenjang');
			$data['permission_siswa'] = $this->input->post('permission_siswa');

			$dataExist = $this->db->get_where('admin', [
				'id_admin' => $where['id_admin']
			])->row_array();
			$cekEmail = $this->db->get_where('login', [
				'email' => $data['email']
			])->row_array();

			if ($cekEmail != null && $cekEmail['email'] != $dataExist['email']) {
				echo json_encode([
					'status' => false,
					'message' => 'Terdapat error pada pengisian form!',
					'nama_error' => form_error('nama'),
					'email_error' => 'The email field must contain a unique value.',
					'password_error' => form_error('password'),
					'gambar_error' => '',
					'permission_buku' => form_error('permission_buku'),
					'permission_kategori_buku' => form_error('permission_kategori_buku'),
					'permission_peminjaman_buku' => form_error('permission_peminjaman_buku'),
					'permission_penyimpanan_buku' => form_error('permission_penyimpanan_buku'),
					'permission_klasifikasi' => form_error('permission_klasifikasi'),
					'permission_siswa' => form_error('permission_siswa')
				]);
				die;
			}

			$where['email'] = $dataExist['email'];

			if ($_FILES['gambar']['name'] != '') {
				$config['upload_path']          = 'assets/image/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
				$config['max_size']             = 1024;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					echo json_encode([
						'status' => false,
						'message' => 'Terdapat error pada pengisian form!',
						'nama_error' => form_error('nama'),
						'email_error' => form_error('email'),
						'password_error' => form_error('password'),
						'gambar_error' => $this->upload->display_errors(),
						'permission_buku' => form_error('permission_buku'),
						'permission_kategori_buku' => form_error('permission_kategori_buku'),
						'permission_peminjaman_buku' => form_error('permission_peminjaman_buku'),
						'permission_penyimpanan_buku' => form_error('permission_penyimpanan_buku'),
						'permission_klasifikasi' => form_error('permission_klasifikasi'),
						'permission_jenjang' => form_error('permission_jenjang'),
						'permission_siswa' => form_error('permission_siswa')
					]);
					die;
				} else {
					$data['gambar'] = $this->upload->data('file_name');
				}
			}

			if ($this->input->post('password') != '' && $this->input->post('password') != null) {
				$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			}

			echo json_encode($this->admin_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'nama_error' => form_error('nama'),
				'email_error' => form_error('email'),
				'password_error' => form_error('password'),
				'gambar_error' => '',
				'permission_buku' => form_error('permission_buku'),
				'permission_kategori_buku' => form_error('permission_kategori_buku'),
				'permission_peminjaman_buku' => form_error('permission_peminjaman_buku'),
				'permission_penyimpanan_buku' => form_error('permission_penyimpanan_buku'),
				'permission_klasifikasi' => form_error('permission_klasifikasi'),
				'permission_jenjang' => form_error('permission_jenjang'),
				'permission_siswa' => form_error('permission_siswa')
			]);
		}
	}

	public function hapus()
	{
		$data['id_admin'] = $this->input->post('id_admin');
		echo json_encode($this->admin_model->hapus($data));
	}
}
