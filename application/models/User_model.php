<?php defined('BASEPATH') OR die('No direct script access allowed');

class User_model extends CI_Model {

     public function getAll()
     {
          $this->db->select('*');
          $this->db->from('absen');

          return $this->db->get();
     }

     public function getAll_by_user()
     {
          $user_id = $_SESSION['id'];
          $this->db->select('*');
          $this->db->where('user_id', $user_id);
          $this->db->from('absen');

          return $this->db->get();
     }

}