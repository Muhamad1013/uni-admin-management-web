<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

  public function get_total_mahasiswa()
  {
    $this->db->select('COUNT(*) as total');
    $this->db->from('mahasiswa');
    $query = $this->db->get();
    return $query->row()->total;
  }

  public function get_total_matakuliah()
  {
    $this->db->select('COUNT(*) as total');
    $this->db->from('matakuliah');
    $query = $this->db->get();
    return $query->row()->total;
  }

  public function get_total_dosen()
  {
    $this->db->select('COUNT(*) as total');
    $this->db->from('dosen');
    $query = $this->db->get();
    return $query->row()->total;
  }


}