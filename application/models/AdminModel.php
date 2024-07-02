<?php
class AdminModel extends CI_Model
{
    var $table = 'admin';
    var $column_order = array(null, 'email', 'nama', null);
    var $column_search = array('email', 'nama');
    var $order = ['nama' => 'ASC'];

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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

    public function findOne($id_admin)
    {
        return $this->db->get_where('admin', [
            'id_admin' => $id_admin
        ])->row_array();
    }

    public function tambah($data)
    {
        $this->db->insert('login', [
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'Admin',
            'is_active' => 1
        ]);

        if ($this->db->affected_rows() > 0) {
            $admin = [
                'email' => $data['email'],
                'nama' => $data['nama']
            ];

            if (isset($data['gambar'])) {
                $admin['gambar'] = $data['gambar'];
            }

            $this->db->insert('admin', $admin);

            if ($this->db->affected_rows() > 0) {
                return [
                    'status' => true
                ];
            } else {
                return [
                    'status' => false
                ];
            }
        } else {
            return [
                'status' => false
            ];
        }
    }

    public function ubah($data, $where)
    {
        $login = [
            'email' => $data['email']
        ];

        if (isset($data['password'])) {
            $login['password'] = $data['password'];
        }

        $this->db->update('login', $login, [
            'email' => $where['email']
        ]);

        $admin = [
            'email' => $data['email'],
            'nama' => $data['nama']
        ];

        if (isset($data['gambar'])) {
            $admin['gambar'] = $data['gambar'];
        }

        if (isset($data['permission_buku'])) {
            $admin['permission_buku'] = $data['permission_buku'];
        }

        if (isset($data['permission_kategori_buku'])) {
            $admin['permission_kategori_buku'] = $data['permission_kategori_buku'];
        }

        if (isset($data['permission_peminjaman_buku'])) {
            $admin['permission_peminjaman_buku'] = $data['permission_peminjaman_buku'];
        }

        if (isset($data['permission_penyimpanan_buku'])) {
            $admin['permission_penyimpanan_buku'] = $data['permission_penyimpanan_buku'];
        }

        if (isset($data['permission_klasifikasi'])) {
            $admin['permission_klasifikasi'] = $data['permission_klasifikasi'];
        }

        if (isset($data['permission_siswa'])) {
            $admin['permission_siswa'] = $data['permission_siswa'];
        }

        $this->db->update('admin', $admin, [
            'id_admin' => $where['id_admin']
        ]);

        return [
            'status' => true
        ];
    }

    public function hapus($data)
    {
        $this->db->delete('admin', $data);

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
