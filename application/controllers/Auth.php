<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Auth_model');
    $this->load->library('form_validation');
    $this->db->query("SET time_zone = '+07:00'");
  }

  public function login()
  {
    $data['title'] = 'Login Page';
    $this->load->view('auth-login-view', $data);

  }

  public function login_process()
  {
    // Get the username and password from the POST request
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    // Fetch the user data based on the username
    $user = $this->Auth_model->get_user_by_username($username);

    // Check if the user exists
    if ($user) {
      // Verify the password against the hashed password in the database
      if (password_verify($password, $user['password'])) {
        // Password is correct, set session data
        $this->session->set_userdata('isLoggedIn', true);
        $this->session->set_userdata('username', $user['username']);
        $this->session->set_userdata('nama_lengkap', $user['nama_lengkap']); // Store full name
        $this->session->set_userdata('user_id', $user['id_admin']); // Ensure this line is present

        // Set profile image from database
        $this->session->set_userdata('profile_image', $user['profile_image']); // Store profile image path

        redirect('dashboard'); // Redirect to the dashboard
      } else {
        // Password is incorrect
        $this->session->set_flashdata('error', 'Invalid username or password');
        redirect('auth/login'); // Redirect back to the login page
      }
    } else {
      // User does not exist
      $this->session->set_flashdata('error', 'Invalid username or password');
      redirect('auth/login'); // Redirect back to the login page
    }
  }

  public function register()
  {
    $data['title'] = 'Register Page';
    $this->load->view('auth-register-view', $data);
  }

  public function register_process()
  {
    // Set validation rules
    $this->form_validation->set_rules('username', 'Username', 'required'); // Removed is_unique
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); // Removed is_unique
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
    $this->form_validation->set_rules('terms', 'Terms', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Validation failed, reload the registration view with errors
      $this->load->view('auth-register-view');
    } else {
      // Prepare data for insertion
      $data = [
        'username' => $this->input->post('username'),
        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'email' => $this->input->post('email'),
        'nama_lengkap' => $this->input->post('nama_lengkap'),
      ];

      // Insert user data into the database
      if ($this->Auth_model->insert_user($data)) {
        // Redirect to success page or login page
        $this->session->set_flashdata('success', 'Registration successful. You can now log in.');
        redirect('auth/login');
      } else {
        // Handle insertion error
        $this->session->set_flashdata('error', 'Registration failed. Please try again.');
        redirect('auth/register');
      }
    }
  }

  public function forgot_password()
  {
    $data['title'] = 'Forgot Password Page';
    $this->load->view('auth-forgot-view', $data);
  }

  public function forgot_password_process()
  {
    $email = $this->input->post('email');
    $user = $this->Auth_model->get_user_by_email($email);

    if ($user) {
      // Generate a new OTP
      $otp = rand(100000, 999999);
      $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

      // Update the OTP in the database
      $this->Auth_model->update_otp($email, $otp, $expiry);

      // Store the email in the session
      $this->session->set_userdata('reset_email', $email);

      // Send OTP via email
      $this->_send_otp_email($email, $otp);
      $this->session->set_flashdata('success', 'OTP has been sent to your email.');
      redirect('auth/verify_otp');
    } else {
      $this->session->set_flashdata('error', 'Email not found.');
      redirect('auth/forgot_password');
    }
  }

  public function verify_otp()
  {
    $data['title'] = 'Verify Page';
    $this->load->view('auth-otp-view', $data);
  }

  public function verify_otp_process()
  {
    // Get the OTP from the POST request
    $otp = $this->input->post('otp');

    // Retrieve the email from the session
    $email = $this->session->userdata('reset_email');

    // Check if the email is set in the session
    if (!$email) {
      $this->session->set_flashdata('error', 'No email found. Please request a new OTP.');
      redirect('auth/forgot_password');
      return; // Exit the function
    }

    // Fetch the user data based on the email
    $user = $this->Auth_model->get_user_by_email($email);

    // Check if the user exists
    if (!$user) {
      $this->session->set_flashdata('error', 'Email not found.');
      redirect('auth/verify_otp');
      return; // Exit the function
    }

    // Validate the OTP
    if ($user['otp_code'] === $otp && strtotime($user['otp_expiry']) > time()) {
      // OTP is valid, allow user to reset password
      $this->session->set_userdata('reset_email', $email);
      redirect('auth/reset_password'); // Redirect to reset password page
    } else {
      // Invalid OTP or OTP has expired
      $this->session->set_flashdata('error', 'Invalid OTP or OTP expired.');
      redirect('auth/verify_otp'); // Redirect back to the OTP verification page
    }
  }


  public function resend_otp()
  {
    $email = $this->session->userdata('reset_email'); // Get the email from session

    if (!$email) {
      $this->session->set_flashdata('error', 'No email found. Please request a new OTP.');
      redirect('auth/forgot_password');
      return;
    }

    // Generate a new OTP
    $otp = rand(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Update the OTP in the database
    if ($this->Auth_model->update_otp_resend($email, $otp, $expiry)) {
      // Send OTP via email
      $this->_send_otp_email($email, $otp);
      $this->session->set_flashdata('success', 'A new OTP has been sent to your email.');
    } else {
      $this->session->set_flashdata('error', 'Failed to resend OTP. Please try again.');
    }

    redirect('auth/verify_otp');
  }

  private function _send_otp_email($email, $otp)
  {
    $this->email->from('your_email@example.com', 'Your Name');
    $this->email->to($email);
    $this->email->subject('Your OTP Code');
    $this->email->message('Your OTP code is: ' . $otp);

    if (!$this->email->send()) {
      log_message('error', 'Failed to send OTP email to ' . $email);
    }
  }
  public function reset_password()
  {
    $data['title'] = 'Reset Password Page';
    $this->load->view('auth-reset-password-view', $data);
  }

  public function reset_password_process()
  {
    // Set validation rules
    $this->form_validation->set_rules('password', 'New Password', 'required|min_length[6]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

    if ($this->form_validation->run() == FALSE) {
      // Validation failed, reload the reset password view with errors
      $this->reset_password(); // Redirect to the reset password page
    } else {
      // Get the email from the session
      $email = $this->session->userdata('reset_email');
      $new_password = $this->input->post('password');

      // Update the password in the database
      if ($this->Auth_model->update_password($email, $new_password)) {
        $this->session->set_flashdata('success', 'Password has been reset successfully.');
        redirect('auth/login');
      } else {
        $this->session->set_flashdata('error', 'Failed to reset password. Please try again.');
        redirect('auth/reset_password');
      }
    }
  }

  public function change_password()
  {
    $data['title'] = 'Change Password Page';

    $this->load->view('header-template-view');
    $this->load->view('settings-change-password-view', $data);
    $this->load->view('footer-template-view');
  }

  public function change_password_process()
  {
    // Set validation rules
    $this->form_validation->set_rules('old_password', 'Old Password', 'required');
    $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

    if ($this->form_validation->run() == FALSE) {
      // Validation failed, reload the change password view with errors
      $this->change_password(); // Redirect to the change password page
    } else {
      // Get the user ID from the session
      $user_id = $this->session->userdata('user_id');

      // Fetch the user's current password from the database
      $user = $this->Auth_model->get_user_by_id($user_id);

      // Verify the old password
      if (password_verify($this->input->post('old_password'), $user['password'])) {
        // Check if the new password is the same as the old password
        if (password_verify($this->input->post('new_password'), $user['password'])) {
          $this->session->set_flashdata('error', 'New password cannot be the same as the old password.');
          redirect('auth/change_password');
        } else {
          // Hash the new password
          $new_password_hash = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);

          // Update the password in the database
          if ($this->Auth_model->update_change_password($user_id, $new_password_hash)) {
            $this->session->set_flashdata('success', 'Password changed successfully.');
            redirect('auth/change_password');
          } else {
            $this->session->set_flashdata('error', 'Failed to change password. Please try again.');
            redirect('auth/change_password');
          }
        }
      } else {
        $this->session->set_flashdata('error', 'Old password is incorrect.');
        redirect('auth/change_password');
      }
    }
  }


  // Method to display the profile settings page
  public function profile()
  {
    // Get the admin ID from the session
    $id_admin = $this->session->userdata('user_id');

    // Check if user ID is set
    if (!$id_admin) {
      $this->session->set_flashdata('error', 'You must be logged in to access this page.');
      redirect('auth/login'); // Redirect to the login page
      return; // Exit the function
    }

    // Fetch user data from the database
    $data['user'] = $this->Auth_model->get_user_by_id($id_admin);

    // Check if user data is found
    if (!$data['user']) {
      $this->session->set_flashdata('error', 'User  not found. Please register.');
      redirect('auth/register'); // Redirect to registration or another appropriate page
      return; // Exit the function
    }

    $data['title'] = 'Settings';

    // Load the views
    $this->load->view('header-template-view');
    $this->load->view('settings-profile-view', $data);
    $this->load->view('footer-template-view');
  }

  public function delete_profile_image()
  {
    $id_admin = $this->session->userdata('user_id');

    // Hapus gambar dari database
    if ($this->Auth_model->remove_profile_image($id_admin)) {
      $this->session->set_flashdata('success', 'Profile image removed successfully.');
      echo json_encode(['success' => true]);
    } else {
      $this->session->set_flashdata('error', 'Failed to remove profile image.');
      echo json_encode(['success' => false]);
    }

    // Redirect back to profile page
    redirect('auth/profile');
  }

  // Method to update the profile
  public function update_profile()
  {
    // Load the form validation library
    $this->load->library('form_validation');

    // Set validation rules
    $this->form_validation->set_rules('firstName', 'First Name', 'required');
    $this->form_validation->set_rules('lastName', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('phoneNumber', 'Phone Number', 'required');
    $this->form_validation->set_rules('address', 'Address', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Validation failed, reload the profile view with errors
      $this->profile(); // Redirect to the profile method to show errors
    } else {
      // Get the admin ID from the session
      $id_admin = $this->session->userdata('user_id');

      // Prepare data for updating
      $data = [
        'nama_lengkap' => $this->input->post('firstName') . ' ' . $this->input->post('lastName'),
        'email' => $this->input->post('email'),
        'no_telepon' => $this->input->post('phoneNumber'),
        'alamat' => $this->input->post('address'),
      ];

      // Handle file upload
      if (!empty($_FILES['upload']['name'])) {
        // Set upload configuration
        $config['upload_path'] = './bootstrap/assets/img/profiles/'; // Set the upload path
        $config['allowed_types'] = 'jpg|jpeg|png'; // Allowed file types
        $config['max_size'] = 800; // Max file size in KB
        $config['encrypt_name'] = TRUE; // Encrypt the file name to avoid conflicts

        // Load the upload library with the configuration
        $this->load->library('upload', $config);

        // Attempt to upload the file
        if ($this->upload->do_upload('upload')) {
          // File upload successful
          $upload_data = $this->upload->data();
          $data['profile_image'] = 'bootstrap/assets/img/profiles/' . $upload_data['file_name']; // Save the new file path

          // Update session with the new profile image path
          $this->session->set_userdata('profile_image', $data['profile_image']);
          log_message('debug', 'File uploaded successfully: ' . $data['profile_image']);
        } else {
          // Handle upload error
          log_message('error', 'Upload error: ' . $this->upload->display_errors());
          $this->session->set_flashdata('error', $this->upload->display_errors());
          redirect('auth/profile'); // Redirect back to the profile page
          return; // Exit the function
        }
      } else {
        // If no file is uploaded, set the profile image to default
        $data['profile_image'] = 'bootstrap/assets/img/profiles/default-avatar.jpg'; // Set to default image
        $this->session->set_userdata('profile_image', $data['profile_image']); // Update session with default image
      }

      // Update the admin's profile in the database
      if ($this->Auth_model->update_profile($id_admin, $data)) {
        // Update session data with the new name
        $this->session->set_userdata('nama_lengkap', $data['nama_lengkap']);

        // Set a success message and redirect
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('auth/profile'); // Redirect to the profile page
      } else {
        // Set an error message if the update fails
        $this->session->set_flashdata('error', 'Failed to update profile. Please try again.');
        redirect('auth/profile'); // Redirect back to the profile page
      }
    }
  }

  public function deactivate_account()
  {
    // Pastikan pengguna sudah login
    if (!$this->session->userdata('user_id')) {
      redirect('auth/login'); // Redirect ke halaman login jika belum login
    }

    // Ambil ID pengguna dari session
    $user_id = $this->session->userdata('user_id');

    // Proses penghapusan akun
    if ($this->input->post('accountActivation')) {
      // Panggil model untuk menghapus akun
      if ($this->Auth_model->delete_account($user_id)) {
        // Hapus data session
        $this->session->sess_destroy();
        // Set pesan sukses
        $this->session->set_flashdata('success', 'Your account has been deleted successfully.');
        redirect('auth/login'); // Redirect ke halaman login
      } else {
        // Set pesan error jika penghapusan gagal
        $this->session->set_flashdata('error', 'Failed to delete your account. Please try again.');
        redirect('auth/profile'); // Redirect kembali ke halaman profil
      }
    } else {
      // Jika checkbox tidak dicentang, set pesan error
      $this->session->set_flashdata('error', 'You must confirm account deactivation.');
      redirect('auth/profile'); // Redirect kembali ke halaman profil
    }
  }
  public function logout()
  {
    // Destroy the session  
    $this->session->sess_destroy();

    redirect('auth/login');
  }
}