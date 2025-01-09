<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
  public function get_matakuliah_report()
  {
    $this->db->select('mk.kode_matakuliah, mk.nama_matakuliah, d.nama_dosen, COUNT(r.id_mahasiswa) as jumlah_mahasiswa');
    $this->db->from('matakuliah mk');
    $this->db->join('registrasi r', 'r.id_matakuliah = mk.id_matakuliah', 'left');
    $this->db->join('dosen d', 'd.id_dosen = r.id_dosen', 'left');
    $this->db->group_by('mk.id_matakuliah'); // Group by matakuliah
    $query = $this->db->get();

    // Debugging: Tampilkan hasil query
    $result = $query->result();
    log_message('debug', 'Query Result: ' . print_r($result, true));

    return $result;
  }

  public function count_search_results($query)
  {
    $this->db->like('mk.nama_matakuliah', $query); // Ganti dengan kolom yang sesuai
    $this->db->from('matakuliah mk');
    $this->db->join('registrasi r', 'r.id_matakuliah = mk.id_matakuliah', 'left');
    $this->db->join('dosen d', 'd.id_dosen = r.id_dosen', 'left');
    return $this->db->count_all_results(); // Hitung total hasil pencarian
  }
  public function search_matakuliah($query)
  {
    $this->db->select('mk.kode_matakuliah, mk.nama_matakuliah, d.nama_dosen, COUNT(r.id_mahasiswa) as jumlah_mahasiswa');
    $this->db->from('matakuliah mk');
    $this->db->join('registrasi r', 'r.id_matakuliah = mk.id_matakuliah', 'left');
    $this->db->join('dosen d', 'd.id_dosen = r.id_dosen', 'left');
    $this->db->like('mk.nama_matakuliah', $query); // Ganti dengan kolom yang sesuai
    $this->db->group_by('mk.id_matakuliah'); // Group by matakuliah
    $query = $this->db->get();
    return $query->result();
  }

  public function get_matakuliah_report_paginated($limit, $offset)
  {
    $this->db->select('mk.kode_matakuliah, mk.nama_matakuliah, d.nama_dosen, COUNT(r.id_mahasiswa) as jumlah_mahasiswa');
    $this->db->from('matakuliah mk');
    $this->db->join('registrasi r', 'r.id_matakuliah = mk.id_matakuliah', 'left');
    $this->db->join('dosen d', 'd.id_dosen = r.id_dosen', 'left');
    $this->db->group_by('mk.id_matakuliah'); // Group by matakuliah
    $this->db->limit($limit, $offset); // Tambahkan limit dan offset
    $query = $this->db->get();
    return $query->result();
  }

  public function get_data_laporan()
  {
    $this->db->select('mk.kode_matakuliah, mk.nama_matakuliah, d.nama_dosen, COUNT(r.id_mahasiswa) as jumlah_mahasiswa');
    $this->db->from('matakuliah mk');
    $this->db->join('registrasi r', 'r.id_matakuliah = mk.id_matakuliah', 'left');
    $this->db->join('dosen d', 'd.id_dosen = r.id_dosen', 'left');
    $this->db->group_by('mk.id_matakuliah'); // Group by matakuliah
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all_matakuliah()
  {
    return $this->db->count_all('matakuliah'); // Hitung total data matakuliah
  }
}
?>