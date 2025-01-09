<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dosen_model extends CI_Model
{
  public function get_selected_columns($columns)
  {
    $this->db->select($columns);
    $query = $this->db->get('dosen');
    return $query->result_array();
  }
  public function get_all_dosen()
  {
    $query = $this->db->get('dosen');
    return $query->result();
  }

  public function get_data_dosen()
  {
    $this->db->order_by('nama_dosen', 'ASC'); // Urutkan berdasarkan nama dosen
    return $this->db->get('dosen')->result();
  }

  public function get_dosen_by_jurusan()
  {
    $this->db->select('jurusan, COUNT(*) as jumlah');
    $this->db->from('dosen'); // Ganti dengan nama tabel yang sesuai
    $this->db->group_by('jurusan');
    $query = $this->db->get();
    return $query->result();
  }

  public function add_dosen($data)
  {
    return $this->db->insert('dosen', $data);
  }

  public function get_dosen_by_id($id_dosen)
  {
    return $this->db->get_where('dosen', ['id_dosen' => $id_dosen])->row();
  }

  public function update_dosen($id_dosen, $data)
  {
    $this->db->where('id_dosen', $id_dosen);
    return $this->db->update('dosen', $data);
  }

  public function delete_dosen($id_dosen)
  {
    return $this->db->delete('dosen', ['id_dosen' => $id_dosen]);
  }

  public function count_all_dosen()
  {
    return $this->db->count_all('dosen');
  }

  public function get_dosen_paginated($limit, $offset)
  {
    $this->db->limit($limit, $offset);
    $query = $this->db->get('dosen');
    return $query->result();
  }
  public function count_search_results($query)
  {
    $this->db->like('nama_dosen', $query); // Mencari berdasarkan nama dosen
    $this->db->or_like('nip', $query); // Mencari berdasarkan NIP
    $this->db->or_like('email', $query); // Mencari berdasarkan email
    $this->db->or_like('telepon', $query); // Mencari berdasarkan telepon
    $this->db->or_like('alamat', $query); // Mencari berdasarkan alamat
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan jurusan

    return $this->db->count_all_results('dosen'); // Mengembalikan jumlah hasil pencarian
  }

  public function search_dosen($query, $limit, $offset)
  {
    $this->db->like('nama_dosen', $query); // Mencari berdasarkan nama dosen
    $this->db->or_like('nip', $query); // Mencari berdasarkan NIP
    $this->db->or_like('email', $query); // Mencari berdasarkan email
    $this->db->or_like('telepon', $query); // Mencari berdasarkan telepon
    $this->db->or_like('alamat', $query); // Mencari berdasarkan alamat
    $this->db->or_like('jurusan', $query); // Mencari berdasarkan jurusan

    $this->db->limit($limit, $offset); // Mengatur limit dan offset
    return $this->db->get('dosen')->result(); // Mengembalikan hasil pencarian
  }

}