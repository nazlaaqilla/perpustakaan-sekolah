<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
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
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'email', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('password', 'password', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() === true) {
            $data = $this->db->get_where('login', [
                'email' => $this->input->post('email')
            ])->row_array();

            if ($data != null) {
                if (password_verify($this->input->post('password'), $data['password'])) {
                    $session = [
                        'login' => true,
                        'email' => $data['email']
                    ];
                    $admin = $this->db->get_where('admin', ['email' => $data['email']])->row_array();
                    $session['id_admin'] = $admin['id_admin'];
                    $session['is_superadmin'] = $admin['is_superadmin'];

                    $this->session->set_userdata($session);
                    redirect('');
                } else {
                    $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', 'Password yang Anda masukkan salah!', 'error')</script>");
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', 'Email address yang Anda masukkan tidak terdaftar!', 'error')</script>");
                redirect('auth');
            }
        } else {
            $this->load->view('template_header');
            $this->load->view('auth/index');
            $this->load->view('template_footer');
        }
    }

    public function profil()
    {
        $this->form_validation->set_rules('email', 'email', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('nama', 'nama', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() === true) {
            $data['email'] = $this->input->post('email');
            $data['nama'] = $this->input->post('nama');

            if ($_FILES['gambar']['name'] != '') {
                $config['upload_path']          = 'assets/image/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|webp|svg|ico';
                $config['max_size']             = 1024;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {
                    $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', '" . strip_tags($this->upload->display_errors()) . "', 'error')</script>");
                    redirect('profil');
                } else {
                    $data['gambar'] = $this->upload->data('file_name');
                }
            }

            $dataCek = $this->db->get_where('login', [
                'email' => $data['email']
            ])->row_array();

            if ($dataCek != null) {
                if ($dataCek['email'] != $this->session->userdata('email')) {
                    $kondisi = 0;
                } else {
                    $kondisi = 1;
                }
            } else {
                $kondisi = 1;
            }

            if ($kondisi == 1) {
                $this->db->update('login', [
                    'email' => $data['email']
                ], [
                    'email' => $this->session->userdata('email')
                ]);

                $this->db->update('admin', $data, [
                    'email' => $data['email']
                ]);
                $this->session->set_flashdata('message', "<script>Swal.fire('Berhasil', 'Profil telah berhasil diubah', 'success')</script>");
            } else {
                $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', 'Email yang anda masukkan telah digunakan!', 'error')</script>");
            }

            redirect('profil');
        } else {
            $data['data'] = $this->db->get_where('admin', [
                'email' => $this->session->userdata('email')
            ])->row_array();
            $this->load->view('template_header');
            $this->load->view('auth/profil', $data);
            $this->load->view('template_footer');
        }
    }

    public function ubah_password()
    {
        $this->form_validation->set_rules('password_lama', 'password_lama', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('password_baru', 'password_baru', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('konfirmasi_password_baru', 'konfirmasi_password_baru', 'required|trim|matches[password_baru]|htmlspecialchars');

        if ($this->form_validation->run() === true) {
            $data = $this->db->get_where('login', [
                'email' => $this->session->userdata('email')
            ])->row_array();

            if (password_verify($this->input->post('password_lama'), $data['password'])) {
                $this->db->update('login', [
                    'password' => password_hash($this->input->post('password_baru'), PASSWORD_BCRYPT)
                ], [
                    'email' => $this->session->userdata('email')
                ]);
                $this->session->set_flashdata('message', "<script>Swal.fire('Berhasil', 'Password anda sudah berhasil diubah', 'success')</script>");
            } else {
                $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', 'Password lama anda salah!', 'error')</script>");
            }

            redirect('ubah_password');
        } else {
            $this->load->view('template_header');
            $this->load->view('auth/ubah_password');
            $this->load->view('template_footer');
        }
    }

    public function website()
    {
        $this->form_validation->set_rules('nama_aplikasi', 'nama_aplikasi', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() === true) {
            $data['nama_aplikasi'] = $this->input->post('nama_aplikasi');

            if ($_FILES['logo_aplikasi']['name'] != '') {
                $config['upload_path']          = 'assets/image';
                $config['allowed_types']        = 'jpeg|jpg|png|bmp|svg';
                $config['max_size']             = 1024;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo_aplikasi')) {
                    $this->session->set_flashdata('message', "<script>Swal.fire('Gagal', '" . strip_tags($this->upload->display_errors()) . "', 'error')</script>");
                    redirect('website');
                } else {
                    $data['logo_aplikasi'] = $this->upload->data('file_name');
                }
            }

            foreach ($data as $key => $list) {
                $this->db->update('konfigurasi', [
                    'nilai' => $list
                ], [
                    'nama' => $key
                ]);
            }

            $this->session->set_flashdata('message', "<script>Swal.fire('Berhasil', 'Website telah berhasil diubah!', 'success')</script>");
            redirect('website');
        } else {
            $data = [
                'nama_aplikasi' => $this->db->get_where('konfigurasi', ['nama' => 'nama_aplikasi'])->row_array()['nilai'],
                'logo_aplikasi' => $this->db->get_where('konfigurasi', ['nama' => 'logo_aplikasi'])->row_array()['nilai']
            ];
            $this->load->view('template_header');
            $this->load->view('auth/website', $data);
            $this->load->view('template_footer');
        }
    }

    public function backup_database()
    {
        if ($this->session->userdata('login') == true) {
            $this->load->dbutil();
            $conf = ['format' => 'sql', 'filename' => 'backup_db.sql'];
            $backup = $this->dbutil->backup($conf);
            $db_name = 'backup_db_' . date("d-m-Y_H-i-s") . '.sql';
            $save = APPPATH . 'database_backup/' . $db_name;
            $this->load->helper('file');
            write_file($save, $backup);
            $this->load->helper('download');
            force_download($db_name, $backup);
        } else {
            show_404();
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
