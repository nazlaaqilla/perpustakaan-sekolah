<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
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
		$this->load->model('BukuModel', 'buku_model');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_buku'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('buku/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->buku_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['isbn'] = $field->isbn;
				$row['judul_buku'] = $field->judul_buku;
				$row['nama_kategori'] = $field->nama_kategori;
				$row['penerbit'] = $field->penerbit;
				$row['pengarang'] = $field->pengarang;
				$row['halaman'] = $field->halaman;
				$row['jumlah'] = $field->jumlah;
				$row['ketersediaan'] = $this->buku_model->stokBuku($field->isbn);
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="info(' . $field->isbn . ')" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Informasi"><i class="fa fa-info-circle"></i></button>
					<button onclick="ubah(' . $field->isbn . ')" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(' . $field->isbn . ')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->buku_model->count_all(),
				"recordsFiltered" => $this->buku_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$data['admin'] = $this->db->get_where('admin', [
			'id_admin' => $this->session->userdata('id_admin')
		])->row_array();
		$data['listKategori'] = $this->db->get('kategori_buku')->result_array();
		$data['listKlasifikasi'] = $this->db->get('klasifikasi')->result_array();
		$this->load->view('buku/tambah', $data);
	}

	public function modal_ubah()
	{
		$isbn = $this->input->post('isbn');
		$data['admin'] = $this->db->get_where('admin', [
			'id_admin' => $this->session->userdata('id_admin')
		])->row_array();
		$data['data'] = $this->db->select('buku.*, penyimpanan_buku.id_klasifikasi')
			->from('buku')
			->join('penyimpanan_buku', 'buku.isbn = penyimpanan_buku.isbn', 'left')
			->where('buku.isbn', $isbn)
			->order_by('tanggal_disimpan', 'DESC')
			->order_by('id_penyimpanan', 'DESC')
			->limit(1, 0)
			->get()
			->row_array();
		$data['listKategori'] = $this->db->get('kategori_buku')->result_array();
		$data['listKlasifikasi'] = $this->db->get('klasifikasi')->result_array();
		$this->load->view('buku/ubah', $data);
	}

	public function modal_info()
	{
		$isbn = $this->input->post('isbn');
		$data['data'] = $this->db->select('buku.*, kategori_buku.nama_kategori')
			->from('buku')
			->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
			->where('buku.isbn', $isbn)
			->get()
			->row_array();
		$data['admin'] = $this->db->get_where('admin', [
			'id_admin' => $this->session->userdata('id_admin')
		])->row_array();
		$data['listPenyimpanan'] = $this->db->select('penyimpanan_buku.*, klasifikasi.nama_klasifikasi, buat.nama AS dibuat_oleh')
			->from('penyimpanan_buku')
			->join('klasifikasi', 'penyimpanan_buku.id_klasifikasi = klasifikasi.id_klasifikasi')
			->join('admin AS buat', 'penyimpanan_buku.created_by = buat.id_admin', 'left')
			->where('penyimpanan_buku.isbn', $isbn)
			->order_by('tanggal_disimpan', 'DESC')
			->order_by('id_penyimpanan', 'DESC')
			->get()
			->result_array();
		$data['generator'] = new Picqer\Barcode\BarcodeGeneratorPNG();
		$this->load->view('buku/info', $data);
	}

	public function export()
	{
		$listBuku = $this->db->select('buku.*, kategori_buku.nama_kategori')
			->from('buku')
			->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
			->order_by('nama_kategori', 'ASC')
			->order_by('isbn', 'ASC')
			->get()
			->result_array();
		$spreadsheet     = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
		$spreadsheet->createSheet();
		$sheet = $spreadsheet->getActiveSheet();
		$row_sekarang = 1;
		$sheet->setCellValue('A' . $row_sekarang, 'No');
		$sheet->setCellValue('B' . $row_sekarang, 'ISBN');
		$sheet->setCellValue('C' . $row_sekarang, 'Judul Buku');
		$sheet->setCellValue('D' . $row_sekarang, 'Kategori Buku');
		$sheet->setCellValue('E' . $row_sekarang, 'Penerbit');
		$sheet->setCellValue('F' . $row_sekarang, 'Pengarang');
		$sheet->setCellValue('G' . $row_sekarang, 'Halaman');
		$sheet->setCellValue('H' . $row_sekarang, 'Jumlah');
		$row_sekarang++;

		if ($listBuku != null) {
			$nomor = 1;

			foreach ($listBuku as $buku) {
				$sheet->setCellValue('A' . $row_sekarang, $nomor++);
				$sheet->setCellValue('B' . $row_sekarang, $buku['isbn']);
				$sheet->setCellValue('C' . $row_sekarang, $buku['judul_buku']);
				$sheet->setCellValue('D' . $row_sekarang, $buku['nama_kategori']);
				$sheet->setCellValue('E' . $row_sekarang, $buku['penerbit']);
				$sheet->setCellValue('F' . $row_sekarang, $buku['pengarang']);
				$sheet->setCellValue('G' . $row_sekarang, $buku['halaman']);
				$sheet->setCellValue('H' . $row_sekarang, $buku['jumlah']);
				$row_sekarang++;
			}
		}

		$sheet->getColumnDimension('A')->setWidth(9);
		$sheet->getColumnDimension('B')->setWidth(10);
		$sheet->getColumnDimension('C')->setWidth(22);
		$sheet->getColumnDimension('D')->setWidth(19);
		$sheet->getColumnDimension('E')->setWidth(12);
		$sheet->getColumnDimension('F')->setWidth(20);
		$sheet->getColumnDimension('G')->setWidth(10);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getStyle('A1:H' . ($row_sekarang - 1))->applyFromArray($styleArray);
		$sheet->getStyle('A1:H1')->getFont()->setBold(true);
		$sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:H' . ($row_sekarang - 1))->getAlignment()->setWrapText(true);
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$this->load->helper('tanggal');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Export Buku ' . tanggal_indo(date('Y-m-d')) . '.xlsx"');
		$writer->save('php://output');
	}

	public function import_excel()
	{
		$path 						= 'excel/';
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'xlsx|xls|csv';
		$config['remove_spaces'] 	= TRUE;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_excel')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
				$arr_file = explode('.', $this->upload->data('file_name'));
				$extension = end($arr_file);

				if ($extension == 'csv') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
			}

			$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$dataTable = [];

			for ($i = 1; $i < count($sheetData); $i++) {
				$isbn 			= trim(rtrim($sheetData[$i]['1']));
				$judul_buku 	= trim(rtrim($sheetData[$i]['2']));
				$kategori_buku 	= trim(rtrim($sheetData[$i]['3']));
				$penerbit 		= trim(rtrim($sheetData[$i]['4']));
				$pengarang 		= trim(rtrim($sheetData[$i]['5']));
				$halaman 		= trim(rtrim($sheetData[$i]['6']));
				$jumlah 		= trim(rtrim($sheetData[$i]['7']));
				$dataKategori 	= $this->db->get_where('kategori_buku', ['nama_kategori' => $kategori_buku])->row_array();
				$dataBuku 		= $this->db->get_where('buku', ['isbn' => $isbn])->row_array();

				if ($dataKategori != null && $dataBuku == null) {
					$dataTable[$i]['isbn'] 				= $isbn;
					$dataTable[$i]['judul_buku'] 		= $judul_buku;
					$dataTable[$i]['id_kategori_buku'] 	= $dataKategori['id_kategori_buku'];
					$dataTable[$i]['nama_kategori'] 	= $dataKategori['nama_kategori'];
					$dataTable[$i]['penerbit'] 			= $penerbit;
					$dataTable[$i]['pengarang'] 		= $pengarang;
					$dataTable[$i]['halaman'] 			= $halaman;
					$dataTable[$i]['jumlah'] 			= $jumlah;
				}
			}

			unlink(realpath('excel/' . $this->upload->data('file_name')));
			$data['listBuku'] = $dataTable;
			$this->load->view('buku/import', $data);
		}
	}

	public function import_process()
	{
		foreach ($this->input->post('isbn') as $key => $isbn) {
			$data['data']['isbn'] = $this->input->post('isbn')[$key];
			$data['data']['judul_buku'] = $this->input->post('judul_buku')[$key];
			$data['data']['id_kategori_buku'] = $this->input->post('id_kategori_buku')[$key];
			$data['data']['penerbit'] = $this->input->post('penerbit')[$key];
			$data['data']['pengarang'] = $this->input->post('pengarang')[$key];
			$data['data']['halaman'] = $this->input->post('halaman')[$key];
			$data['data']['jumlah'] = $this->input->post('jumlah')[$key];
			$data['data']['created_by'] = $this->session->userdata('id_admin');
			$data['data']['updated_by'] = $this->session->userdata('id_admin');
			$this->buku_model->tambah($data);
		}

		echo json_encode([
			'status' => true
		]);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('isbn', 'isbn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('judul_buku', 'judul_buku', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('id_kategori_buku', 'id_kategori_buku', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('penerbit', 'penerbit', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('pengarang', 'pengarang', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('halaman', 'halaman', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('id_klasifikasi', 'id_klasifikasi', 'trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$data['data']['isbn'] = $this->input->post('isbn');
			$data['data']['judul_buku'] = $this->input->post('judul_buku');
			$data['data']['id_kategori_buku'] = $this->input->post('id_kategori_buku');
			$data['data']['penerbit'] = $this->input->post('penerbit');
			$data['data']['pengarang'] = $this->input->post('pengarang');
			$data['data']['halaman'] = $this->input->post('halaman');
			$data['data']['jumlah'] = $this->input->post('jumlah');
			$data['data']['created_by'] = $this->session->userdata('id_admin');
			$data['data']['updated_by'] = $this->session->userdata('id_admin');

			if ($this->input->post('id_klasifikasi') != null && $this->input->post('id_klasifikasi') != '') {
				$data['penyimpanan']['id_klasifikasi'] = $this->input->post('id_klasifikasi');
			}

			$config['upload_path']          = 'assets/cover_buku/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
			$config['max_size']             = 1024;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('cover')) {
				echo json_encode([
					'status' => false,
					'message' => 'Terdapat error pada pengisian form!',
					'isbn_error' => form_error('isbn'),
					'judul_buku_error' => form_error('judul_buku'),
					'id_kategori_buku_error' => form_error('id_kategori_buku'),
					'penerbit_error' => form_error('penerbit'),
					'pengarang_error' => form_error('pengarang'),
					'halaman_error' => form_error('halaman'),
					'jumlah_error' => form_error('jumlah'),
					'cover_error' => $this->upload->display_errors(),
					'id_klasifikasi_error' => form_error('id_klasifikasi')
				]);
				die;
			} else {
				$data['data']['cover'] = $this->upload->data('file_name');
			}

			echo json_encode($this->buku_model->tambah($data));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'isbn_error' => form_error('isbn'),
				'judul_buku_error' => form_error('judul_buku'),
				'id_kategori_buku_error' => form_error('id_kategori_buku'),
				'penerbit_error' => form_error('penerbit'),
				'pengarang_error' => form_error('pengarang'),
				'halaman_error' => form_error('halaman'),
				'jumlah_error' => form_error('jumlah'),
				'cover_error' => '',
				'id_klasifikasi_error' => form_error('id_klasifikasi')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('isbn_lama', 'isbn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('isbn', 'isbn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('judul_buku', 'judul_buku', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('id_kategori_buku', 'id_kategori_buku', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('penerbit', 'penerbit', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('pengarang', 'pengarang', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('halaman', 'halaman', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('id_klasifikasi', 'id_klasifikasi', 'trim|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$where['isbn'] = $this->input->post('isbn_lama');
			$data['data']['isbn'] = $this->input->post('isbn');
			$data['data']['judul_buku'] = $this->input->post('judul_buku');
			$data['data']['id_kategori_buku'] = $this->input->post('id_kategori_buku');
			$data['data']['penerbit'] = $this->input->post('penerbit');
			$data['data']['pengarang'] = $this->input->post('pengarang');
			$data['data']['halaman'] = $this->input->post('halaman');
			$data['data']['jumlah'] = $this->input->post('jumlah');
			$data['data']['updated_by'] = $this->session->userdata('id_admin');

			if ($this->input->post('id_klasifikasi') != null && $this->input->post('id_klasifikasi') != '') {
				$data['penyimpanan']['id_klasifikasi'] = $this->input->post('id_klasifikasi');
			}

			if ($_FILES['cover']['name'] != '') {
				$config['upload_path']          = 'assets/cover_buku/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
				$config['max_size']             = 1024;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('cover')) {
					echo json_encode([
						'status' => false,
						'message' => 'Terdapat error pada pengisian form!',
						'isbn_error' => form_error('isbn'),
						'judul_buku_error' => form_error('judul_buku'),
						'id_kategori_buku_error' => form_error('id_kategori_buku'),
						'penerbit_error' => form_error('penerbit'),
						'pengarang_error' => form_error('pengarang'),
						'halaman_error' => form_error('halaman'),
						'jumlah_error' => form_error('jumlah'),
						'cover_error' => $this->upload->display_errors(),
						'id_klasifikasi_error' => form_error('id_klasifikasi')
					]);
					die;
				} else {
					$data['data']['cover'] = $this->upload->data('file_name');
				}
			}

			echo json_encode($this->buku_model->ubah($data, $where));
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'isbn_error' => form_error('isbn'),
				'judul_buku_error' => form_error('judul_buku'),
				'id_kategori_buku_error' => form_error('id_kategori_buku'),
				'penerbit_error' => form_error('penerbit'),
				'pengarang_error' => form_error('pengarang'),
				'halaman_error' => form_error('halaman'),
				'jumlah_error' => form_error('jumlah'),
				'cover_error' => '',
				'id_klasifikasi_error' => form_error('id_klasifikasi')
			]);
		}
	}

	public function hapus()
	{
		$data['isbn'] = $this->input->post('isbn');
		echo json_encode($this->buku_model->hapus($data));
	}
}
