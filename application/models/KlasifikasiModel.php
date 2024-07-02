<?php
class KlasifikasiModel extends CI_Model
{
    var $table = 'klasifikasi';
    var $column_order = array(null, 'nama_klasifikasi', 'dibuat_oleh', 'diubah_oleh', null);
    var $column_search = array('nama_klasifikasi', 'dibuat_oleh', 'diubah_oleh');
    var $order = ['nama_klasifikasi' => 'ASC'];

    private function _get_datatables_query()
    {
        $this->db->select('klasifikasi.*, buat.nama AS dibuat_oleh, ubah.nama AS diubah_oleh');
        $this->db->from($this->table);
        $this->db->join('admin AS buat', 'klasifikasi.created_by = buat.id_admin', 'left');
        $this->db->join('admin AS ubah', 'klasifikasi.updated_by = ubah.id_admin', 'left');
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

    public function findOne($id_klasifikasi)
    {
        return $this->db->get_where('klasifikasi', [
            'id_klasifikasi' => $id_klasifikasi
        ])->row_array();
    }

    public function tambah($data)
    {
        $this->db->insert('klasifikasi', $data);

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
        $this->db->update('klasifikasi', $data, $where);

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
        $this->db->delete('klasifikasi', $data);

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
