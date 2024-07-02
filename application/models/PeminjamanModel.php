<?php
class PeminjamanModel extends CI_Model
{
    var $table = 'peminjaman_buku';
    var $column_order = array(null, 'nisn', 'nama', 'nomor_ponsel', 'judul_buku', 'tanggal_peminjaman', 'tanggal_pengembalian', 'jumlah', 'lama_peminjaman', 'dibuat_oleh', 'diubah_oleh', null);
    var $column_search = array('nisn', 'nama', 'nomor_ponsel', 'judul_buku', 'tanggal_peminjaman', 'tanggal_pengembalian', 'jumlah', 'lama_peminjaman', 'dibuat_oleh', 'diubah_oleh');
    var $order = ['tanggal_peminjaman' => 'DESC', 'id_peminjaman' => 'DESC'];

    private function _get_datatables_query()
    {
        $this->db->select("peminjaman_buku.*, siswa.nama, CONCAT('+62',siswa.nomor_ponsel) AS nomor_ponsel, buku.judul_buku, buat.nama AS dibuat_oleh, ubah.nama AS diubah_oleh");
        $this->db->from($this->table);
        $this->db->join('buku', 'peminjaman_buku.isbn = buku.isbn');
        $this->db->join('siswa', 'peminjaman_buku.nisn = siswa.nisn');
        $this->db->join('admin AS buat', 'peminjaman_buku.created_by = buat.id_admin', 'left');
        $this->db->join('admin AS ubah', 'peminjaman_buku.updated_by = ubah.id_admin', 'left');
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

    public function findOne($id_peminjaman)
    {
        return $this->db->get_where('peminjaman_buku', [
            'id_peminjaman' => $id_peminjaman
        ])->row_array();
    }

    public function tambah($data)
    {
        $this->db->insert('peminjaman_buku', $data);

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

    public function ubah($data, $where)
    {
        $this->db->update('peminjaman_buku', $data, $where);

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

    public function hapus($data)
    {
        $this->db->delete('peminjaman_buku', $data);

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
