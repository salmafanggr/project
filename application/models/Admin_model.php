<?php defined('BASEPATH') OR die('No direct script access allowed');

class Admin_model extends CI_Model {

      public function list()
      {
         $hasil=$this->db->get('user');
         $result = $hasil->result_array();
         $response = array(
            "aaData" => $result
         );
         return $response;
      }

      function get_data_by_id($id){
         $hasil=$this->db->query("SELECT * FROM user WHERE id='$id'");
         if($hasil->num_rows()>0){
            foreach ($hasil->result() as $data) {
               $hasil=array(
                     'id' => $data->id,
                     'name' => $data->name,
                     'nip' => $data->nip,
                     'jurusan' => $data->jurusan,
                     'email' => $data->email,
                     );
            }
         }
         return $hasil;
      }

     function update_user(){
        $id=$this->input->post('id');
        $nama=$this->input->post('name');
        $nip=$this->input->post('nip');
        $jurusan=$this->input->post('jurusan');
        $email=$this->input->post('email');
 
        $this->db->set('id', $id);
        $this->db->set('name', $nama);
        $this->db->set('nip', $nip);
        $this->db->set('jurusan', $jurusan);
        $this->db->set('email', $email);
        $this->db->where('id', $id);
        $result=$this->db->update('user');
        return $result;
    }

    function hapus_data($id){
      $hasil=$this->db->query("DELETE FROM user WHERE id='$id'");
      return $hasil;
    }

    function confirm_data(){
      $id=$this->input->post('id');
      $is_confirm=$this->input->post('is_confirm');

      $check = $this->db->query("SELECT * FROM user WHERE id='$id'")->row();
      
      if($check->is_confirm == 0){
         $this->db->set('is_confirm', $is_confirm);
         $this->db->where('id', $id);
         $hasil=$this->db->update('user');
         return $hasil;
      }else{
         return false;
      }
      
    }
}