<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
    }

    public function index()
    {
        $data['listKategori'] = $this->db->select('kategori_buku.*, COUNT(id_peminjaman) AS jumlah_terpinjam')
            ->from('peminjaman_buku')
            ->join('buku', 'peminjaman_buku.isbn = buku.isbn')
            ->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
            ->group_by('buku.id_kategori_buku')
            ->order_by('jumlah_terpinjam', 'ASC')
            ->limit(5)
            ->get()
            ->result_array();
        $data['listBukuTerfavorit'] = $this->db->select('buku.isbn, buku.judul_buku, buku.cover, kategori_buku.nama_kategori, COUNT(id_peminjaman) AS jumlah_terpinjam')
            ->from('peminjaman_buku')
            ->join('buku', 'peminjaman_buku.isbn = buku.isbn')
            ->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
            ->group_by('peminjaman_buku.isbn')
            ->order_by('jumlah_terpinjam', 'ASC')
            ->limit(6)
            ->get()
            ->result_array();
        $this->load->view('template_header');
        $this->load->view('dashboard/index', $data);
        $this->load->view('template_footer');
    }

    public function admin()
    {
        if ($this->session->userdata('login') == true) {
            $data['kategori_buku'] = $this->db->get('kategori_buku')->num_rows();
            $data['jenjang'] = $this->db->get('jenjang')->num_rows();
            $data['klasifikasi'] = $this->db->get('klasifikasi')->num_rows();
            $data['buku'] = $this->db->get('buku')->num_rows();
            $data['siswa'] = $this->db->get('siswa')->num_rows();
            $data['admin'] = $this->db->get('admin')->num_rows();
            $this->load->view('template_header');
            $this->load->view('dashboard/admin', $data);
            $this->load->view('template_footer');
        } else {
            show_404();
        }
    }

    public function pencarian()
    {
        $search = $this->input->post('search');

        if ($search != '') {
            $data['listBuku'] = $this->db->select('buku.*, kategori_buku.nama_kategori, klasifikasi.nama_klasifikasi')
                ->from('buku')
                ->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
                ->join('penyimpanan_buku', 'buku.isbn = penyimpanan_buku.isbn', 'left')
                ->join('klasifikasi', 'penyimpanan_buku.id_klasifikasi = klasifikasi.id_klasifikasi', 'left')
                ->where("judul_buku LIKE '%$search%'", null, false)
                ->or_where("buku.isbn LIKE '%$search%'", null, false)
                ->or_where("penerbit LIKE '%$search%'", null, false)
                ->or_where("pengarang LIKE '%$search%'", null, false)
                ->or_where("kategori_buku.nama_kategori LIKE '%$search%'", null, false)
                ->order_by('tanggal_disimpan', 'DESC')
                ->order_by('id_penyimpanan', 'DESC')
                ->group_by('buku.isbn')
                ->get()
                ->result_array();
            $this->load->view('dashboard/pencarian', $data);
        }
    }

    public function info_buku($isbn)
    {
        $data['buku'] = $this->db->select('buku.*, kategori_buku.nama_kategori')
            ->from('buku')
            ->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
            ->where('isbn', $isbn)
            ->get()
            ->row_array();

        if ($data['buku'] != null) {
            $this->load->view('template_header');
            $this->load->view('dashboard/info_buku', $data);
            $this->load->view('template_footer');
        } else {
            show_404();
        }
    }

    public function kategori($id_kategori_buku)
    {
        $data['data'] = $this->db->get_where('kategori_buku', ['id_kategori_buku' => $id_kategori_buku])->row_array();

        if ($data['data'] != null) {
            $data['listBuku'] = $this->db->select('buku.*, kategori_buku.nama_kategori')
                ->from('buku')
                ->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku')
                ->where('buku.id_kategori_buku', $id_kategori_buku)
                ->get()
                ->result_array();
            $this->load->view('template_header');
            $this->load->view('dashboard/daftar_buku', $data);
            $this->load->view('template_footer');
        } else {
            show_404();
        }
    }
}
