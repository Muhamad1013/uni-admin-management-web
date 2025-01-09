<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Matakuliah_model extends CI_Model
{
  public function get_selected_columns($columns)
  {
    $this->db->select($columns);
    $query = $this->db->get('matakuliah');
    return $query->result_array();
  }

  public function get_all_matakuliah()
  {
    $query = $this->db->get('matakuliah');
    return $query->result();
  }

  public function get_matakuliah_by_jurusan()
  {
    $this->db->select('jurusan, COUNT(*) as jumlah');
    $this->db->from('matakuliah'); // Ganti dengan nama tabel yang sesuai
    $this->db->group_by('jurusan');
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all_matakuliah()
  {
    return $this->db->count_all('matakuliah');
  }

  // Mengambil data Matakuliah dengan limit dan offset
  public function get_matakuliah_paginated($limit, $offset)
  {
    $this->db->limit($limit, $offset);
    $query = $this->db->get('matakuliah');
    return $query->result();
  }

  // Mengambil data matakuliah berdasarkan ID
  public function get_matakuliah_by_id($id_matakuliah)
  {
    return $this->db->get_where('matakuliah', ['id_matakuliah' => $id_matakuliah])->row(); // Mengambil data berdasarkan ID
  }

  public function get_data_matakuliah()
  {
    $this->db->order_by('nama_matakuliah', 'ASC'); // Urutkan berdasarkan nama matakuliah
    return $this->db->get('matakuliah')->result();
  }

  // Menambahkan data matakuliah
  public function add_matakuliah($data)
  {
    return $this->db->insert('matakuliah', $data); // Menyimpan data ke tabel matakuliah
  }

  public function get_kode_matakuliah_by_id($id_matakuliah)
  {
    $this->db->select('kode_matakuliah');
    $this->db->from('matakuliah');
    $this->db->where('id_matakuliah', $id_matakuliah);
    return $this->db->get()->row(); // Mengembalikan satu baris data
  }

  // Memperbarui data matakuliah
  public function update_matakuliah($id_matakuliah, $data)
  {
    $this->db->where('id_matakuliah', $id_matakuliah); // Menentukan ID yang akan diperbarui
    return $this->db->update('matakuliah', $data); // Memperbarui data di tabel matakuliah
  }

  // Menghapus data matakuliah
  public function delete_matakuliah($id_matakuliah)
  {
    return $this->db->delete('matakuliah', ['id_matakuliah' => $id_matakuliah]); // Menghapus data berdasarkan ID
  }

  public function count_search_results($query)
  {
    // Menggunakan query builder untuk mencari di beberapa kolom
    $this->db->like('kode_matakuliah', $query); // Mencari berdasarkan Kode Matakuliah
    $this->db->or_like('nama_matakuliah', $query); // Mencari berdasarkan Nama Matakuliah
    $this->db->or_like('sks', $query); // Mencari berdasarkan SKS
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan Jurusan

    return $this->db->count_all_results('matakuliah'); // Mengembalikan jumlah hasil pencarian
  }

  public function search_matakuliah($query, $limit, $offset)
  {
    $this->db->like('kode_matakuliah', $query); // Mencari berdasarkan Kode Matakuliah
    $this->db->or_like('nama_matakuliah', $query); // Mencari berdasarkan Nama Matakuliah
    $this->db->or_like('sks', $query); // Mencari berdasarkan SKS
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan Jurusan

    $this->db->limit($limit, $offset); // Mengatur limit dan offset
    return $this->db->get('matakuliah')->result(); // Mengembalikan hasil pencarian
  }
}