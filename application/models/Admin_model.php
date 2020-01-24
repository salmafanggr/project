<?php defined('BASEPATH') OR die('No direct script access allowed');

class Admin_model extends CI_Model {

     public function list()
     {
        $hasil=$this->db->get('user');
        return $hasil->result_array();
     }

     function update_user(){
        $id=$this->input->post('id');
        $nama=$this->input->post('name');
        $nip=$this->input->post('nip');
        $jurusan=$this->input->post('jurusan');
 
        $this->db->set('id', $id);
        $this->db->set('name', $nama);
        $this->db->set('nip', $nip);
        $this->db->set('jurusan', $jurusan);
        $this->db->where('id', $id);
        $result=$this->db->update('user');
        return $result;
    }

}