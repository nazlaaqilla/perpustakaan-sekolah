<?php
class BukuModel extends CI_Model
{
    var $table = 'buku';
    var $column_order = array(null, 'isbn', 'judul_buku', 'nama_kategori', 'penerbit', 'pengarang', 'halaman', 'jumlah', null, 'dibuat_oleh', 'diubah_oleh', null);
    var $column_search = array('isbn', 'judul_buku', 'nama_kategori', 'penerbit', 'pengarang', 'halaman', 'jumlah', 'dibuat_oleh', 'diubah_oleh');
    var $order = ['judul_buku' => 'ASC'];

    private function _get_datatables_query()
    {
        $this->db->select('buku.*, kategori_buku.nama_kategori, buat.nama AS dibuat_oleh, ubah.nama AS diubah_oleh');
        $this->db->from($this->table);
        $this->db->join('kategori_buku', 'buku.id_kategori_buku = kategori_buku.id_kategori_buku');
        $this->db->join('admin AS buat', 'buku.created_by = buat.id_admin', 'left');
        $this->db->join('admin AS ubah', 'buku.updated_by = ubah.id_admin', 'left');
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_GET['search']['value']) {
                if ($i === 0) {
                    $this->db->having($item . " LIKE '%" . $_GET['search']['value'] . "%'", null, false);
                } else {
                    $this->db->or_having($item . " LIKE '%" . $_GET['search']['value'] . "%'", null, false);
                }
            }

            $i++;
        }

        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();

        if ($_GET['length'] != -1) {
            $this->db->limit($_GET['length'], $_GET['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function findOne($isbn)
    {
        return $this->db->get_where('buku', [
            'isbn' => $isbn
        ])->row_array();
    }

    public function stokBuku($isbn)
    {
        $dikembalikan = (int) $this->db->select('SUM(jumlah) AS total')
            ->from('peminjaman_buku')
            ->where([
                'isbn' => $isbn,
                'is_dikembalikan' => 1
            ])
            ->get()
            ->row_array()['total'];
        $dipinjam = (int) $this->db->select('SUM(jumlah) AS total')
            ->from('peminjaman_buku')
            ->where([
                'isbn' => $isbn
            ])
            ->get()
            ->row_array()['total'];
        $buku = $this->findOne($isbn);
        $total = (int) $buku['jumlah'] - ($dipinjam - $dikembalikan);
        return $total;
    }

    public function tambah($data)
    {
        $this->db->insert('buku', $data['data']);

        if ($this->db->affected_rows() > 0) {
            if (isset($data['penyimpanan'])) {
                $this->db->insert('penyimpanan_buku', [
                    'isbn' => $data['data']['isbn'],
                    'id_klasifikasi' => $data['penyimpanan']['id_klasifikasi'],
                    'created_by' => $this->session->userdata('id_admin')
                ]);
            }

            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }

    public function ubah($data, $where)
    {
        $this->db->update('buku', $data['data'], $where);
        $id_klasifikasi = $this->db->select('id_klasifikasi')
            ->from('penyimpanan_buku')
            ->where('isbn', $data['data']['isbn'])
            ->limit(1, 0)
            ->order_by('tanggal_disimpan', 'DESC')
            ->order_by('id_penyimpanan', 'DESC')
            ->get()
            ->row_array()['id_klasifikasi'];
        $kondisi = 0;

        if ($this->db->affected_rows() > 0) {
            $kondisi = 1;
        }

        if ($id_klasifikasi != $data['penyimpanan']['id_klasifikasi']) {
            $this->db->insert('penyimpanan_buku', [
                'isbn' => $data['data']['isbn'],
                'id_klasifikasi' => $data['penyimpanan']['id_klasifikasi'],
                'created_by' => $this->session->userdata('id_admin')
            ]);

            if ($this->db->affected_rows() > 0) {
                $kondisi = 1;
            }
        }

        if ($kondisi == 1) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }

    public function hapus($data)
    {
        $this->db->delete('buku', $data);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }
}
