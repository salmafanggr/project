<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['tittle'] = 'Daftar Guru';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function show(){
        $data=$this->admin_model->list();
        echo json_encode($data);
    }

    function get_data(){
        $id=$this->input->get('id');
        $data=$this->admin_model->get_data_by_id($id);
        echo json_encode($data);
    }

    public function update(){
        $data=$this->admin_model->update_user();
        echo json_encode($data);
    }

    public function hapus(){
        $id=$this->input->post('id');
        $data=$this->admin_model->hapus_data($id);
        echo json_encode($data);
    }

    public function confirm(){
        $data=$this->admin_model->confirm_data();
        echo json_encode($data);
    }
}
