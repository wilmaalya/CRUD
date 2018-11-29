<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
//            jika belum login redirect ke login
        if ($this->session->userdata('logged') <> 1) {
            redirect(site_url('auth'));
        }
    }

    public function index() {
        $this->load->model('user_model');

        $rows = $this->user_model->tampilkanSemua()->result();

        $data = array(
            'title' => 'Trilili.com',
            'judul' => 'Halaman User',
            'content' => 'user',
            'rows' => $rows
        );
//		echo 'ini adalah controller user';
        $this->load->view('layout', $data);
    }

    public function tambah() {
        $this->load->library('form_validation');

        $data = array(
            'title' => 'Trilili.com',
            'action' => base_url() . 'user/aksitambah',
            'content' => 'user_form',
            'username' => set_value('username', ''),
            'password' => set_value('password', ''),
            'id_user' => set_value('id_user', ''),
            'tombol' => 'Tambah'
        );

        $this->load->view('layout', $data);
    }

    public function aksitambah() {

//        load library form validation
        $this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

//        rules validasi
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[10]');

        if ($this->form_validation->run() == FALSE) {
//            jika validasi gagal
            $this->tambah();
        } else {
//            jika validasi berhasil
            $data = array(
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password'))
            );

            $this->load->model('user_model');
            $this->user_model->tambah($data);

            redirect(base_url() . 'index.php/user');
        }
    }

    public function ubah($id) {

        $this->load->model('user_model');
        $row = $this->user_model->getById($id)->row();

        $data = array(
            'title' => 'trilili.com',
            'action' => base_url() . 'user/aksiubah',
            'content' => 'user_form',
            'username' => $row->username,
            'password' => '',
            'id_user' => $row->id_user,
            'tombol' => 'Ubah'
        );

        $this->load->view('layout', $data);
    }

    public function aksiubah() {

//            warning : aksi ini tanpa ada validasi form
        $updatepassword = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))
        );

        $tidakupdatepassword = array(
            'username' => $this->input->post('username'),
        );

        $data = trim($this->input->post('password')) <> '' ? $updatepassword : $tidakupdatepassword;

        $this->load->model('user_model');
        $this->user_model->ubah($this->input->post('id_user'), $data);

        redirect(base_url() . 'user');
    }

    public function delete($id) {

        $this->load->model('user_model');
        $this->user_model->hapus($id);

        redirect(base_url() . 'user');
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
//uhuy