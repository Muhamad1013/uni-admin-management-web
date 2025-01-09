<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
  public function get_selected_columns($columns)
  {
    $this->db->select($columns);
    $query = $this->db->get('mahasiswa');
    return $query->result_array();
  }

  public function get_mahasiswa_by_jurusan()
  {
    $this->db->select('jurusan, COUNT(*) as jumlah');
    $this->db->from('mahasiswa'); // Ganti dengan nama tabel yang sesuai
    $this->db->group_by('jurusan');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_mahasiswa($limit)
  {
    $this->db->limit($limit); // Mengatur limit query
    $query = $this->db->get('mahasiswa'); // Mengambil data dari tabel mahasiswa
    return $query->result();
  }

  // Fungsi untuk mengambil semua data mahasiswa
  public function get_all_mahasiswa()
  {
    $query = $this->db->get('mahasiswa');
    return $query->result();
  }

  public function get_data_mahasiswa()
  {
    $this->db->order_by('nama_mahasiswa', 'ASC'); // Urutkan berdasarkan nama mahasiswa
    return $this->db->get('mahasiswa')->result();
  }


  public function count_all_mahasiswa()
  {
    return $this->db->count_all('mahasiswa');
  }


  // Mengambil data mahasiswa dengan limit dan offset
  public function get_mahasiswa_paginated($limit, $offset)
  {
    $this->db->limit($limit, $offset);
    $query = $this->db->get('mahasiswa');
    return $query->result();
  }

  public function get_mahasiswa_by_id($id_mahasiswa)
  {
    return $this->db->get_where('mahasiswa', ['id_mahasiswa' => $id_mahasiswa])->row(); // Menggunakan row() untuk mendapatkan objek
  }

  public function update_mahasiswa($id_mahasiswa, $data)
  {
    $this->db->where('id_mahasiswa', $id_mahasiswa);
    return $this->db->update('mahasiswa', $data); // Memperbarui data mahasiswa
  }

  public function add_mahasiswa($data)
  {
    return $this->db->insert('mahasiswa', $data);
  }

  public function delete_mahasiswa($id_mahasiswa)
  {
    return $this->db->delete('mahasiswa', ['id_mahasiswa' => $id_mahasiswa]); // Menghapus data mahasiswa
  }
  public function count_search_results($query)
  {
    // Menggunakan query builder untuk mencari di beberapa kolom
    $this->db->like('id_mahasiswa', $query); // Mencari berdasarkan ID
    $this->db->or_like('nama_mahasiswa', $query); // Mencari berdasarkan nama
    $this->db->or_like('nim', $query); // Mencari berdasarkan NIM
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan jurusan
    $this->db->or_like('email', $query); // Mencari berdasarkan email
    $this->db->or_like('telepon', $query); // Mencari berdasarkan telepon
    $this->db->or_like('alamat', $query); // Mencari berdasarkan alamat

    return $this->db->count_all_results('mahasiswa'); // Mengembalikan jumlah hasil pencarian
  }

  public function search_mahasiswa($query, $limit, $offset)
  {
    $this->db->like('id_mahasiswa', $query); // Mencari berdasarkan ID
    $this->db->or_like('nama_mahasiswa', $query); // Mencari berdasarkan nama
    $this->db->or_like('nim', $query); // Mencari berdasarkan NIM
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan jurusan
    $this->db->or_like('email', $query); // Mencari berdasarkan email
    $this->db->or_like('telepon', $query); // Mencari berdasarkan telepon
    $this->db->or_like('alamat', $query); // Mencari berdasarkan alamat

    $this->db->limit($limit, $offset); // Mengatur limit dan offset
    return $this->db->get('mahasiswa')->result(); // Mengembalikan hasil pencarian
  }


}
?>