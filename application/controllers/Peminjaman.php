<?php
defined('BASEPATH') or exit('No direct script access allowed');

class peminjaman extends CI_Controller
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
		$this->load->model('PeminjamanModel', 'peminjaman_model');
		$this->load->helper('tanggal');

		if ($this->session->userdata('login') != true) {
			redirect('auth');
		}

		if ($this->session->userdata('is_superadmin') != 1) {
			$admin = $this->db->get_where('admin', [
				'id_admin' => $this->session->userdata('id_admin')
			])->row_array();

			if ($admin['permission_peminjaman_buku'] != 1) {
				show_404();
			}
		}
	}

	public function index()
	{
		$this->load->view('template_header');
		$this->load->view('peminjaman/index');
		$this->load->view('template_footer');
	}

	public function ambil_data()
	{
		if ($this->input->is_ajax_request() == true) {
			$list = $this->peminjaman_model->get_datatables();
			$data = array();
			$no = $_GET['start'];

			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['nisn'] = $field->nisn;
				$row['nama'] = $field->nama;
				$row['nomor_ponsel'] = $field->nomor_ponsel;
				$row['judul_buku'] = $field->judul_buku;
				$row['tanggal_peminjaman'] = tanggal_indo($field->tanggal_peminjaman);
				$row['tanggal_pengembalian'] = $field->is_dikembalikan ? tanggal_indo($field->tanggal_pengembalian) : tanggal_indo(date('Y-m-d', strtotime($field->tanggal_peminjaman) + (60 * 60 * 24 * $field->lama_peminjaman))) . ' (estimasi)';
				$row['jumlah'] = $field->jumlah;
				$row['lama_peminjaman'] = $field->lama_peminjaman;
				$row['dibuat_oleh'] = $field->dibuat_oleh;
				$row['diubah_oleh'] = $field->diubah_oleh;
				$row['aksi'] = '<div class="d-flex justify-content-center align-items-center gap-1">
					<button onclick="ubah(' . $field->id_peminjaman . ')" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"><i class="fa fa-edit"></i></button>
					<button onclick="hapus(' . $field->id_peminjaman . ')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
				</div>
				';
				$data[] = $row;
			}

			$output = array(
				"draw" => $_GET['draw'],
				"recordsTotal" => $this->peminjaman_model->count_all(),
				"recordsFiltered" => $this->peminjaman_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function modal_tambah()
	{
		$this->load->model('BukuModel', 'buku_model');
		$data['listSiswa'] = $this->db->get('siswa')->result_array();
		$data['listBuku'] = $this->db->get('buku')->result_array();
		$this->load->view('peminjaman/tambah', $data);
	}

	public function modal_ubah()
	{
		$this->load->model('BukuModel', 'buku_model');
		$id_peminjaman = $this->input->post('id_peminjaman');
		$data['listSiswa'] = $this->db->get('siswa')->result_array();
		$data['listBuku'] = $this->db->get('buku')->result_array();
		$data['data'] = $this->peminjaman_model->findOne($id_peminjaman);
		$this->load->view('peminjaman/ubah', $data);
	}

	public function export()
	{
		$listPeminjaman = $this->db->select("peminjaman_buku.*, siswa.nama, CONCAT('+62',siswa.nomor_ponsel) AS nomor_ponsel, buku.judul_buku")
			->from('peminjaman_buku')
			->join('buku', 'peminjaman_buku.isbn = buku.isbn')
			->join('siswa', 'peminjaman_buku.nisn = siswa.nisn')
			->order_by('isbn', 'ASC')
			->order_by('nisn', 'ASC')
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
		$sheet->setCellValue('B' . $row_sekarang, 'NISN');
		$sheet->setCellValue('C' . $row_sekarang, 'Nama');
		$sheet->setCellValue('D' . $row_sekarang, 'Nomor Ponsel');
		$sheet->setCellValue('E' . $row_sekarang, 'Judul Buku');
		$sheet->setCellValue('F' . $row_sekarang, 'Peminjaman');
		$sheet->setCellValue('G' . $row_sekarang, 'Pengembalian');
		$sheet->setCellValue('H' . $row_sekarang, 'Jumlah');
		$sheet->setCellValue('I' . $row_sekarang, 'Lama Peminjaman');
		$row_sekarang++;

		if ($listPeminjaman != null) {
			$nomor = 1;

			foreach ($listPeminjaman as $buku) {
				$sheet->setCellValue('A' . $row_sekarang, $nomor++);
				$sheet->setCellValue('B' . $row_sekarang, $buku['nisn']);
				$sheet->setCellValue('C' . $row_sekarang, $buku['nama']);
				$sheet->setCellValue('D' . $row_sekarang, $buku['nomor_ponsel']);
				$sheet->setCellValue('E' . $row_sekarang, $buku['judul_buku']);
				$sheet->setCellValue('F' . $row_sekarang, tanggal_indo($buku['tanggal_peminjaman']));
				$sheet->setCellValue('G' . $row_sekarang, $buku['is_dikembalikan'] ? tanggal_indo($buku['tanggal_pengembalian']) : tanggal_indo(date('Y-m-d', strtotime($buku['tanggal_peminjaman']) + (60 * 60 * 24 * $buku['lama_peminjaman']))) . ' (estimasi)');
				$sheet->setCellValue('H' . $row_sekarang, $buku['jumlah']);
				$sheet->setCellValue('I' . $row_sekarang, $buku['lama_peminjaman']);
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
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getStyle('A1:I' . ($row_sekarang - 1))->applyFromArray($styleArray);
		$sheet->getStyle('A1:I1')->getFont()->setBold(true);
		$sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:I' . ($row_sekarang - 1))->getAlignment()->setWrapText(true);
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$this->load->helper('tanggal');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Export Peminjaman ' . tanggal_indo(date('Y-m-d')) . '.xlsx"');
		$writer->save('php://output');
	}

	public function tambah()
	{
		$this->form_validation->set_rules('nisn', 'nisn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('isbn', 'isbn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('tanggal_peminjaman', 'tanggal_peminjaman', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('tanggal_pengembalian', 'tanggal_pengembalian', ($this->input->post('is_dikembalikan') == '1' ? 'required|' : '') . 'trim|htmlspecialchars');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('lama_peminjaman', 'lama_peminjaman', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('is_dikembalikan', 'is_dikembalikan', 'required|trim|in_list[0,1]|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$this->load->model('BukuModel', 'buku_model');
			$data['nisn'] = $this->input->post('nisn');
			$data['isbn'] = $this->input->post('isbn');
			$data['tanggal_peminjaman'] = $this->input->post('tanggal_peminjaman');
			$data['tanggal_pengembalian'] = $this->input->post('is_dikembalikan') == 0 ? null : $this->input->post('tanggal_pengembalian');
			$data['jumlah'] = $this->input->post('jumlah');
			$data['lama_peminjaman'] = $this->input->post('lama_peminjaman');
			$data['is_dikembalikan'] = $this->input->post('is_dikembalikan');
			$data['created_by'] = $this->session->userdata('id_admin');
			$data['updated_by'] = $this->session->userdata('id_admin');
			$stok = $this->buku_model->stokBuku($data['isbn']);

			if ($stok - $data['jumlah'] >= 0) {
				echo json_encode($this->peminjaman_model->tambah($data));
			} else {
				echo json_encode([
					'status' => false,
					'message' => 'Terdapat error pada pengisian form!',
					'isbn_error' => form_error('isbn'),
					'email_error' => form_error('email'),
					'tanggal_peminjaman_error' => form_error('tanggal_peminjaman'),
					'tanggal_pengembalian_error' => form_error('tanggal_pengembalian'),
					'jumlah_error' => 'The jumlah field is exceeded to the book\'s stock',
					'lama_peminjaman_error' => form_error('lama_peminjaman')
				]);
			}
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'isbn_error' => form_error('isbn'),
				'email_error' => form_error('email'),
				'tanggal_peminjaman_error' => form_error('tanggal_peminjaman'),
				'tanggal_pengembalian_error' => form_error('tanggal_pengembalian'),
				'jumlah_error' => form_error('jumlah'),
				'lama_peminjaman_error' => form_error('lama_peminjaman')
			]);
		}
	}

	public function ubah()
	{
		$this->form_validation->set_rules('id_peminjaman', 'id_peminjaman', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nisn', 'nisn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('isbn', 'isbn', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('tanggal_peminjaman', 'tanggal_peminjaman', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('tanggal_pengembalian', 'tanggal_pengembalian', ($this->input->post('is_dikembalikan') == '1' ? 'required|' : '') . 'trim|htmlspecialchars');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('lama_peminjaman', 'lama_peminjaman', 'required|trim|numeric|htmlspecialchars');
		$this->form_validation->set_rules('is_dikembalikan', 'is_dikembalikan', 'required|trim|in_list[0,1]|htmlspecialchars');

		if ($this->form_validation->run() === true) {
			$this->load->model('BukuModel', 'buku_model');
			$where['id_peminjaman'] = $this->input->post('id_peminjaman');
			$data['nisn'] = $this->input->post('nisn');
			$data['isbn'] = $this->input->post('isbn');
			$data['tanggal_peminjaman'] = $this->input->post('tanggal_peminjaman');
			$data['tanggal_pengembalian'] = $this->input->post('is_dikembalikan') == 0 ? null : $this->input->post('tanggal_pengembalian');
			$data['jumlah'] = $this->input->post('jumlah');
			$data['lama_peminjaman'] = $this->input->post('lama_peminjaman');
			$data['is_dikembalikan'] = $this->input->post('is_dikembalikan');
			$data['updated_by'] = $this->session->userdata('id_admin');
			$peminjaman = $this->db->get_where('peminjaman_buku', $where)->row_array();
			$stok = $this->buku_model->stokBuku($data['isbn']);
			$stok = $peminjaman['isbn'] == $data['isbn'] ? $stok + $peminjaman['jumlah'] : $stok;

			if ($stok - $data['jumlah'] >= 0) {
				echo json_encode($this->peminjaman_model->ubah($data, $where));
			} else {
				echo json_encode([
					'status' => false,
					'message' => 'Terdapat error pada pengisian form!',
					'isbn_error' => form_error('isbn'),
					'email_error' => form_error('email'),
					'tanggal_peminjaman_error' => form_error('tanggal_peminjaman'),
					'tanggal_pengembalian_error' => form_error('tanggal_pengembalian'),
					'jumlah_error' => 'The jumlah field is exceeded to the book\'s stock',
					'lama_peminjaman_error' => form_error('lama_peminjaman')
				]);
			}
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Terdapat error pada pengisian form!',
				'isbn_error' => form_error('isbn'),
				'email_error' => form_error('email'),
				'tanggal_peminjaman_error' => form_error('tanggal_peminjaman'),
				'tanggal_pengembalian_error' => form_error('tanggal_pengembalian'),
				'jumlah_error' => form_error('jumlah'),
				'lama_peminjaman_error' => form_error('lama_peminjaman')
			]);
		}
	}

	public function hapus()
	{
		$data['id_peminjaman'] = $this->input->post('id_peminjaman');
		echo json_encode($this->peminjaman_model->hapus($data));
	}
}
