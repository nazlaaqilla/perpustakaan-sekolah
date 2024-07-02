<?php
class SubRakPenyimpananModel extends CI_Model
{
    var $table = 'sub_rak_penyimpanan';
    var $column_order = array(null, 'nama_kategori', 'kode_rak', 'nama_rak', 'nama_sub_rak', 'dibuat_oleh', 'diubah_oleh', null);
    var $column_search = array('nama_kategori', 'kode_rak', 'nama_rak', 'nama_sub_rak', 'dibuat_oleh', 'diubah_oleh');
    var $order = ['nama_kategori' => 'ASC', 'kode_rak' => 'ASC'];

    private function _get_datatables_query()
    {
        $this->db->select('sub_rak_penyimpanan.*, rak_penyimpanan.nama_rak, kategori_buku.nama_kategori, buat.nama AS dibuat_oleh, ubah.nama AS diubah_oleh');
        $this->db->from($this->table);
        $this->db->join('rak_penyimpanan', 'sub_rak_penyimpanan.kode_rak = rak_penyimpanan.kode_rak');
        $this->db->join('kategori_buku', 'rak_penyimpanan.id_kategori_buku = kategori_buku.id_kategori_buku');
        $this->db->join('admin AS buat', 'sub_rak_penyimpanan.created_by = buat.id_admin', 'left');
        $this->db->join('admin AS ubah', 'sub_rak_penyimpanan.updated_by = ubah.id_admin', 'left');
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

    public function findOne($id_sub_rak)
    {
        return $this->db->get_where('sub_rak_penyimpanan', [
            'id_sub_rak' => $id_sub_rak
        ])->row_array();
    }

    public function tambah($data)
    {
        $this->db->insert('sub_rak_penyimpanan', $data);

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
        $this->db->update('sub_rak_penyimpanan', $data, $where);

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
        $this->db->delete('sub_rak_penyimpanan', $data);

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
