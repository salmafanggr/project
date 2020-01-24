<?php defined('BASEPATH') OR die('No direct script access allowed');

class Absen_model extends CI_Model {

     public function getAll()
     {
          $this->db->select('*');
          $this->db->from('absen');

          return $this->db->get();
     }

}