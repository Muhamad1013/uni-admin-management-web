<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }


  public function get_user_by_email($email)
  {
    return $this->db->get_where('admin', ['email' => $email])->row_array();
  }

  public function insert_user($data)
  {
    return $this->db->insert('admin', $data);
  }

  public function update_otp($email, $otp, $expiry)
  {
    return $this->db->update('admin', ['otp_code' => $otp, 'otp_expiry' => $expiry], ['email' => $email]);
  }

  public function update_otp_resend($email, $otp, $expiry)
  {
    return $this->db->update('admin', ['otp_code' => $otp, 'otp_expiry' => $expiry], ['email' => $email]);
  }

  public function get_user_by_email_resend($email)
  {
    return $this->db->get_where('admin', ['email' => $email])->row_array();
  }

  // Method to get user by username (for login)
  public function get_user_by_username($username)
  {
    $this->db->where('username', $username);
    return $this->db->get('admin')->row_array();
  }

  // Method to get user by ID
  public function get_user_by_id($id_admin)
  {
    $this->db->where('id_admin', $id_admin);
    return $this->db->get('admin')->row_array();
  }

  public function update_profile($id_admin, $data)
  {
    $this->db->where('id_admin', $id_admin);
    return $this->db->update('admin', $data);
  }

  public function remove_profile_image($id_admin)
  {
    $this->db->set('profile_image', NULL); // Set profile_image to NULL
    $this->db->where('id_admin', $id_admin);
    return $this->db->update('admin');
  }

  public function update_password($email, $password)
  {
    // Hash the new password before updating
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $this->db->where('email', $email); // Pastikan untuk menggunakan where berdasarkan email
    return $this->db->update('admin', ['password' => $hashed_password]);
  }


  public function update_change_password($user_id, $new_password)
  {
    // Update the password in the database
    $this->db->set('password', $new_password);
    $this->db->where('id_admin', $user_id); // Pastikan untuk menggunakan ID yang benar
    return $this->db->update('admin'); // Mengembalikan true jika berhasil
  }

  public function delete_account($user_id)
  {
    // Hapus akun dari tabel pengguna
    $this->db->where('id_admin', $user_id); // Pastikan untuk menggunakan ID yang benar
    return $this->db->delete('admin'); // Mengembalikan true jika berhasil
  }


}