<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_model extends CI_Model
{
  public function get_registrasi_by_semester()
  {
    $this->db->select('semester, COUNT(*) as jumlah');
    $this->db->from('registrasi');
    $this->db->group_by('semester');
    return $this->db->get()->result(); // Mengembalikan data pendaftaran berdasarkan semester
  }

  // Mengambil data pendaftaran berdasarkan dosen
  public function get_registrasi_by_dosen()
  {
    $this->db->select('id_dosen, COUNT(*) as jumlah');
    $this->db->from('registrasi');
    $this->db->group_by('id_dosen');
    return $this->db->get()->result(); // Mengembalikan data pendaftaran berdasarkan dosen
  }

  // Mengambil data pendaftaran berdasarkan tahun ajaran
  public function get_registrasi_by_tahun_ajaran()
  {
    $this->db->select('tahun_ajaran, COUNT(*) as jumlah');
    $this->db->from('registrasi');
    $this->db->group_by('tahun_ajaran');
    return $this->db->get()->result(); // Mengembalikan data pendaftaran berdasarkan tahun ajaran
  }
  public function count_all_registrations()
  {
    return $this->db->count_all('registrasi'); // Menghitung total pendaftaran
  }
  public function get_registrations_paginated($limit, $offset)
  {
    $this->db->select('r.*, m.nama_mahasiswa, d.nama_dosen, mk.nama_matakuliah');
    $this->db->from('registrasi r');
    $this->db->join('mahasiswa m', 'r.id_mahasiswa = m.id_mahasiswa');
    $this->db->join('dosen d', 'r.id_dosen = d.id_dosen');
    $this->db->join('matakuliah mk', 'r.id_matakuliah = mk.id_matakuliah');
    $this->db->limit($limit, $offset);
    return $this->db->get()->result();
  }
  public function insert_registration($data)
  {
    return $this->db->insert('registrasi', $data); // Menyimpan data pendaftaran
  }

  public function get_registrasi_by_id($id)
  {
    $this->db->select('registrasi.*, mahasiswa.nama_mahasiswa, mahasiswa.nim, dosen.nama_dosen, matakuliah.nama_matakuliah');
    $this->db->from('registrasi');
    $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = registrasi.id_mahasiswa');
    $this->db->join('dosen', 'dosen.id_dosen = registrasi.id_dosen');
    $this->db->join('matakuliah', 'matakuliah.id_matakuliah = registrasi.id_matakuliah');
    $this->db->where('registrasi.id_registrasi', $id); // Filter berdasarkan ID registrasi
    return $this->db->get()->row(); // Mengembalikan satu baris data registrasi
  }
  public function get_all_mahasiswa()
  {
    $this->db->distinct(); // Menghindari duplikat
    $this->db->select('id_mahasiswa, nama_mahasiswa'); // Pastikan hanya mengambil kolom yang diperlukan
    $this->db->order_by('nama_mahasiswa', 'ASC'); // Mengurutkan berdasarkan nama mahasiswa
    return $this->db->get('mahasiswa')->result(); // Mengembalikan semua data mahasiswa
  }

  // Mengambil semua dosen tanpa duplikat dan diurutkan
  public function get_all_dosen()
  {
    $this->db->distinct(); // Menghindari duplikat
    $this->db->select('id_dosen, nama_dosen'); // Pastikan hanya mengambil kolom yang diperlukan
    $this->db->order_by('nama_dosen', 'ASC'); // Mengurutkan berdasarkan nama dosen
    return $this->db->get('dosen')->result(); // Mengembalikan semua data dosen
  }

  // Mengambil semua matakuliah tanpa duplikat dan diurutkan
  public function get_all_matakuliah()
  {
    $this->db->distinct(); // Menghindari duplikat
    $this->db->select('id_matakuliah, nama_matakuliah'); // Pastikan hanya mengambil kolom yang diperlukan
    $this->db->order_by('nama_matakuliah', 'ASC'); // Mengurutkan berdasarkan nama matakuliah
    return $this->db->get('matakuliah')->result(); // Mengembalikan semua data matakuliah
  }

  public function get_all_registrasi()
  {
    $this->db->select('registrasi.*, mahasiswa.nim, mahasiswa.nama_mahasiswa, dosen.nama_dosen, matakuliah.nama_matakuliah');
    $this->db->from('registrasi');
    $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = registrasi.id_mahasiswa');
    $this->db->join('dosen', 'dosen.id_dosen = registrasi.id_dosen');
    $this->db->join('matakuliah', 'matakuliah.id_matakuliah = registrasi.id_matakuliah');
    return $this->db->get()->result(); // Mengembalikan semua data registrasi
  }


  // Mengambil data registrasi berdasarkan ID

  public function update_registration($id, $data)
  {
    $this->db->where('id_registrasi', $id);
    return $this->db->update('registrasi', $data); // Memperbarui data pendaftaran
  }


  public function delete_registration($id)
  {
    return $this->db->delete('registrasi', ['id_registrasi' => $id]); // Menghapus data pendaftaran ```php
  }

  public function get_registration_by_id($id)
  {
    $this->db->select('registrasi.*, mahasiswa.nama_mahasiswa, dosen.nama_dosen, matakuliah.nama_matakuliah');
    $this->db->from('registrasi');
    $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = registrasi.id_mahasiswa');
    $this->db->join('dosen', 'dosen.id_dosen = registrasi.id_dosen');
    $this->db->join('matakuliah', 'matakuliah.id_matakuliah = registrasi.id_matakuliah');
    $this->db->where('registrasi.id_registrasi', $id); // Filter berdasarkan ID registrasi
    return $this->db->get()->row(); // Mengembalikan satu baris data registrasi
  }

  public function count_search_results($query, $semester = null, $tahun_ajaran = null)
  {
    $this->db->select('r.*');
    $this->db->from('registrasi r');
    $this->db->join('mahasiswa m', 'r.id_mahasiswa = m.id_mahasiswa', 'left');
    $this->db->join('dosen d', 'r.id_dosen = d.id_dosen', 'left');
    $this->db->join('matakuliah mk', 'r.id_matakuliah = mk.id_matakuliah', 'left');

    // Grup untuk kondisi OR
    $this->db->group_start();
    $this->db->like('m.nama_mahasiswa', $query);
    $this->db->or_like('d.nama_dosen', $query);
    $this->db->or_like('mk.nama_matakuliah', $query);
    $this->db->or_like('m.jurusan', $query); // Menambahkan alias tabel
    $this->db->or_like('r.tahun_ajaran', $query); // Menambahkan alias tabel
    $this->db->group_end();

    // Tambahkan kondisi untuk semester dan tahun ajaran jika ada
    if ($semester) {
      $this->db->where('r.semester', $semester);
    }
    if ($tahun_ajaran) {
      $this->db->where('r.tahun_ajaran', $tahun_ajaran);
    }

    return $this->db->count_all_results(); // Menghitung total hasil pencarian
  }

  public function search_registrations($query, $limit, $offset, $semester = null, $tahun_ajaran = null)
  {
    $this->db->select('r.*, m.nama_mahasiswa, d.nama_dosen, mk.nama_matakuliah');
    $this->db->from('registrasi r');
    $this->db->join('mahasiswa m', 'r.id_mahasiswa = m.id_mahasiswa', 'left');
    $this->db->join('dosen d', 'r.id_dosen = d.id_dosen', 'left');
    $this->db->join('matakuliah mk', 'r.id_matakuliah = mk.id_matakuliah', 'left');

    // Grup untuk kondisi OR
    $this->db->group_start();
    $this->db->like('m.nama_mahasiswa', $query);
    $this->db->or_like('d.nama_dosen', $query);
    $this->db->or_like('mk.nama_matakuliah', $query);
    $this->db->or_like('m.jurusan', $query); // Menambahkan alias tabel
    $this->db->or_like('r.tahun_ajaran', $query); // Menambahkan alias tabel
    $this->db->group_end();

    // Tambahkan kondisi untuk semester dan tahun ajaran jika ada
    if ($semester) {
      $this->db->where('r.semester', $semester);
    }
    if ($tahun_ajaran) {
      $this->db->where('r.tahun_ajaran', $tahun_ajaran);
    }

    $this->db->limit($limit, $offset);
    return $this->db->get()->result(); // Mengambil data pendaftaran yang sesuai dengan pencarian
  }



}