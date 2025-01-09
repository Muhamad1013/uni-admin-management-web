<?php
defined('BASEPATH') or exit('No direct script access allowed');


use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->model('Mahasiswa_model');
		$this->load->model('Dosen_model');
		$this->load->model('Matakuliah_model');
		$this->load->model('Registration_model');
		$this->load->model('Laporan_model');
		$this->load->library('pagination');
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['total_mahasiswa'] = $this->Dashboard_model->get_total_mahasiswa();
		$data['total_matakuliah'] = $this->Dashboard_model->get_total_matakuliah();
		$data['total_dosen'] = $this->Dashboard_model->get_total_dosen();

		$this->load->view('header-template-view');
		$this->load->view('dashboard-view', $data);
		$this->load->view('footer-template-view');
	}

	public function export_pdf_mahasiswa()
	{
		$this->load->model('Mahasiswa_model');
		$mahasiswa = $this->Mahasiswa_model->get_all_mahasiswa(); // Ambil semua data mahasiswa

		// Inisialisasi Dompdf
		$options = new Options();
		$options->set('defaultFont', 'Courier');
		$dompdf = new Dompdf($options);

		// Buat HTML untuk PDF
		$html = '<h1>Data Mahasiswa</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Tanggal Lahir</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                    </tr>
                  </thead>
                  <tbody>';

		foreach ($mahasiswa as $index => $data) {
			$html .= '<tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . htmlspecialchars($data->nama_mahasiswa) . '</td>
                        <td>' . htmlspecialchars($data->nim) . '</td>
                        <td>' . htmlspecialchars($data->tanggal_lahir) . '</td>
                        <td>' . htmlspecialchars($data->jurusan) . '</td>
                        <td>' . htmlspecialchars($data->email) . '</td>
                        <td>' . htmlspecialchars($data->telepon) . '</td>
                        <td>' . htmlspecialchars($data->alamat) . '</td>
                      </tr>';
		}

		$html .= '</tbody></table>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// (Optional) Set ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("data_mahasiswa.pdf", array("Attachment" => true));
	}

	public function export_pdf_laporan()
	{
		$this->load->model('Laporan_model'); // Pastikan model sudah dimuat
		$data['matakuliah_report'] = $this->Laporan_model->get_data_laporan(); // Ambil data laporan matakuliah

		// Inisialisasi Dompdf
		$options = new Options();
		$options->set('defaultFont', 'Courier');
		$dompdf = new Dompdf($options);

		// Buat HTML untuk PDF
		$html = '<h1>Laporan Matakuliah</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead>
                <tr>
                    <th>No</th>
                    <th>Kode Matakuliah</th>
                    <th>Nama Matakuliah</th>
                    <th>Dosen</th>
                    <th>Jumlah Mahasiswa</th>
                </tr>
              </thead>
              <tbody>';

		foreach ($data['matakuliah_report'] as $index => $report) {
			$html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($report->kode_matakuliah) . '</td>
                    <td>' . htmlspecialchars($report->nama_matakuliah) . '</td>
                    <td>' . htmlspecialchars($report->nama_dosen) . '</td>
                    <td>' . htmlspecialchars($report->jumlah_mahasiswa) . '</td>
                  </tr>';
		}

		$html .= '</tbody></table>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// (Optional) Set ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("laporan_laporan.pdf", array("Attachment" => true));
	}

	public function export_pdf_dosen()
	{
		$this->load->model('Dosen_model');
		$dosen = $this->Dosen_model->get_all_dosen(); // Ambil semua data dosen

		// Inisialisasi Dompdf
		$options = new Options();
		$options->set('defaultFont', 'Courier');
		$dompdf = new Dompdf($options);

		// Buat HTML untuk PDF
		$html = '<h1>Data Dosen</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>';

		foreach ($dosen as $index => $data) {
			$html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($data->nama_dosen) . '</td>
                    <td>' . htmlspecialchars($data->nip) . '</td>
                    <td>' . htmlspecialchars($data->email) . '</td>
                    <td>' . htmlspecialchars($data->telepon) . '</td>
                    <td>' . htmlspecialchars($data->alamat) . '</td>
                    <td>' . htmlspecialchars($data->jurusan) . '</td>
                  </tr>';
		}

		$html .= '</tbody></table>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// (Optional) Set ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("data_dosen.pdf", array("Attachment" => true));
	}

	public function export_pdf_matakuliah()
	{
		$this->load->model('Matakuliah_model');
		$matakuliah = $this->Matakuliah_model->get_all_matakuliah(); // Ambil semua data matakuliah

		// Inisialisasi Dompdf
		$options = new Options();
		$options->set('defaultFont', 'Courier');
		$dompdf = new Dompdf($options);

		// Buat HTML untuk PDF
		$html = '<h1>Data Matakuliah</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Matakuliah</th>
                        <th>Nama Matakuliah</th>
                        <th>SKS</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>';

		foreach ($matakuliah as $index => $data) {
			$html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($data->kode_matakuliah) . '</td>
                    <td>' . htmlspecialchars($data->nama_matakuliah) . '</td>
                    <td>' . htmlspecialchars($data->sks) . '</td>
                    <td>' . htmlspecialchars($data->jurusan) . '</td>
                  </tr>';
		}

		$html .= '</tbody></table>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// (Optional) Set ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("data_matakuliah.pdf", array("Attachment" => true));
	}

	public function export_pdf_registrasi()
	{
		$this->load->model('Registration_model'); // Pastikan model yang benar dimuat
		$registrasi = $this->Registration_model->get_all_registrasi(); // Ambil semua data registrasi

		// Inisialisasi Dompdf
		$options = new Options();
		$options->set('defaultFont', 'Courier');
		$dompdf = new Dompdf($options);

		// Buat HTML untuk PDF
		$html = '<h1>Data Registrasi</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Dosen</th>
                    <th>Matakuliah</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                </tr>
              </thead>
              <tbody>';

		foreach ($registrasi as $index => $data) {
			$html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($data->nama_mahasiswa) . '</td>
                    <td>' . htmlspecialchars($data->nim) . '</td>
                    <td>' . htmlspecialchars($data->nama_dosen) . '</td>
                    <td>' . htmlspecialchars($data->nama_matakuliah) . '</td>
                    <td>' . htmlspecialchars($data->semester) . '</td>
                    <td>' . htmlspecialchars($data->tahun_ajaran) . '</td>
                  </tr>';
		}

		$html .= '</tbody></table>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// (Optional) Set ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream("data_registrasi.pdf", array("Attachment" => true));
	}

	public function export_csv_mahasiswa()
	{
		$this->load->model('Mahasiswa_model');
		$mahasiswa = $this->Mahasiswa_model->get_all_mahasiswa(); // Ambil semua data mahasiswa

		// Set header untuk download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="data_mahasiswa.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Buka output stream
		$output = fopen('php://output', 'w');

		// Tulis header kolom
		fputcsv($output, ['No', 'Nama Lengkap', 'NIM', 'Tanggal Lahir', 'Jurusan', 'Email', 'Telepon', 'Alamat']);

		// Tulis data mahasiswa
		foreach ($mahasiswa as $index => $data) {
			fputcsv($output, [
				$index + 1,
				$data->nama_mahasiswa,
				$data->nim,
				$data->tanggal_lahir,
				$data->jurusan,
				$data->email,
				$data->telepon,
				$data->alamat
			]);
		}

		// Tutup output stream
		fclose($output);
		exit();
	}

	public function export_csv_laporan()
	{
		$this->load->model('Laporan_model'); // Pastikan model sudah dimuat
		$data['matakuliah_report'] = $this->Laporan_model->get_data_laporan(); // Ambil data laporan matakuliah

		// Set header untuk download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="data_laporan.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Buka output stream
		$output = fopen('php://output', 'w');

		// Tulis header kolom
		fputcsv($output, ['No', 'Kode Matakuliah', 'Nama Matakuliah', 'Dosen', 'Jumlah Mahasiswa']);

		// Tulis data laporan matakuliah
		foreach ($data['matakuliah_report'] as $index => $report) {
			fputcsv($output, [
				$index + 1,
				$report->kode_matakuliah,
				$report->nama_matakuliah,
				$report->nama_dosen,
				$report->jumlah_mahasiswa
			]);
		}

		// Tutup output stream
		fclose($output);
		exit();
	}

	public function export_csv_dosen()
	{
		$this->load->model('Dosen_model');
		$dosen = $this->Dosen_model->get_all_dosen(); // Ambil semua data dosen

		// Set header untuk download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="data_dosen.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Buka output stream
		$output = fopen('php://output', 'w');

		// Tulis header kolom
		fputcsv($output, ['No', 'Nama Dosen', 'NIP', 'Email', 'Telepon', 'Alamat', 'Jurusan']);

		// Tulis data dosen
		foreach ($dosen as $index => $data) {
			fputcsv($output, [
				$index + 1,
				$data->nama_dosen, // Menggunakan nama_dosen
				$data->nip, // Menggunakan nip
				$data->email, // Menggunakan email
				$data->telepon, // Menggunakan telepon
				$data->alamat, // Menggunakan alamat
				$data->jurusan // Menggunakan jurusan
			]);
		}

		// Tutup output stream
		fclose($output);
		exit();
	}

	public function export_csv_matakuliah()
	{
		$this->load->model('Matakuliah_model');
		$matakuliah = $this->Matakuliah_model->get_all_matakuliah(); // Ambil semua data matakuliah

		// Set header untuk download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="data_matakuliah.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Buka output stream
		$output = fopen('php://output', 'w');

		// Tulis header kolom
		fputcsv($output, ['No', 'Kode Matakuliah', 'Nama Matakuliah', 'SKS', 'Jurusan']);

		// Tulis data matakuliah
		foreach ($matakuliah as $index => $data) {
			fputcsv($output, [
				$index + 1, // Nomor urut
				$data->kode_matakuliah, // Kode Matakuliah
				$data->nama_matakuliah, // Nama Matakuliah
				$data->sks, // SKS
				$data->jurusan // Jurusan
			]);
		}

		// Tutup output stream
		fclose($output);
		exit();
	}

	public function export_csv_registrasi()
	{
		$this->load->model('Registration_model'); // Pastikan model yang benar dimuat
		$registrasi = $this->Registration_model->get_all_registrasi(); // Ambil semua data registrasi

		// Set header untuk download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="data_registrasi.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Buka output stream
		$output = fopen('php://output', 'w');

		// Tulis header kolom
		fputcsv($output, ['No', 'Nama Mahasiswa', 'NIM', 'Dosen', 'Matakuliah', 'Semester', 'Tahun Ajaran']);

		// Tulis data registrasi
		foreach ($registrasi as $index => $data) {
			fputcsv($output, [
				$index + 1,
				$data->nama_mahasiswa, // Pastikan ini sesuai dengan data yang diambil
				$data->nim, // Pastikan NIM diambil dari data mahasiswa
				$data->nama_dosen, // Ambil nama dosen
				$data->nama_matakuliah, // Ambil nama matakuliah
				$data->semester, // Ambil semester
				$data->tahun_ajaran // Ambil tahun ajaran
			]);
		}

		// Tutup output stream
		fclose($output);
		exit();
	}

	public function grafik_view_mahasiswa()
	{
		$data['title'] = 'Grafik Mahasiswa';
		// Ambil data mahasiswa berdasarkan jurusan
		$data['mahasiswa'] = $this->Mahasiswa_model->get_mahasiswa_by_jurusan();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-grafik-view', $data); // Kirim data ke view
		$this->load->view('footer-template-view');
	}

	public function grafik_view_dosen()
	{
		$data['title'] = 'Grafik Dosen';
		// Ambil data mahasiswa berdasarkan jurusan
		$data['dosen'] = $this->Dosen_model->get_dosen_by_jurusan();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('dosen-grafik-view', $data); // Kirim data ke view
		$this->load->view('footer-template-view');
	}

	public function grafik_view_matakuliah()
	{
		$data['title'] = 'Grafik Matakuliah';
		// Ambil data mahasiswa berdasarkan jurusan
		$data['matakuliah'] = $this->Matakuliah_model->get_matakuliah_by_jurusan();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-grafik-view', $data); // Kirim data ke view
		$this->load->view('footer-template-view');
	}
	public function grafik_view_registrasi()
	{
		$data['title'] = 'Grafik Registrasi';

		// Memuat model
		$this->load->model('Registration_model');

		// Ambil data pendaftaran berdasarkan semester, dosen, dan tahun ajaran
		$data['registrasi_semester'] = $this->Registration_model->get_registrasi_by_semester();
		$data['registrasi_dosen'] = $this->Registration_model->get_registrasi_by_dosen();
		$data['registrasi_tahun_ajaran'] = $this->Registration_model->get_registrasi_by_tahun_ajaran();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('registrasi-grafik-view', $data); // Kirim data ke view
		$this->load->view('footer-template-view');
	}

	public function get_chart_data($filter)
	{
		$this->load->model('Registration_model');

		switch ($filter) {
			case 'semester':
				$data = $this->Registration_model->get_registrasi_by_semester();
				break;
			case 'dosen':
				$data = $this->Registration_model->get_registrasi_by_dosen();
				break;
			case 'tahun_ajaran':
				$data = $this->Registration_model->get_registrasi_by_tahun_ajaran();
				break;
			default:
				echo json_encode(['labels' => [], 'data' => []]);
				return;
		}

		$labels = [];
		$jumlah = [];

		foreach ($data as $row) {
			if ($filter == 'semester') {
				$labels[] = $row->semester;
			} elseif ($filter == 'dosen') {
				// Ambil nama dosen jika perlu
				$this->db->select('nama_dosen');
				$this->db->from('dosen');
				$this->db->where('id_dosen', $row->id_dosen);
				$dosen = $this->db->get()->row();
				$labels[] = $dosen ? $dosen->nama_dosen : 'Unknown Dosen';
			} elseif ($filter == 'tahun_ajaran') {
				$labels[] = $row->tahun_ajaran;
			}
			$jumlah[] = $row->jumlah;
		}

		echo json_encode(['labels' => $labels, 'data' => $jumlah]);
	}


	public function mahasiswa($offset = 0)
	{
		$data['title'] = 'Mahasiswa';

		// Ambil query pencarian jika ada
		$query = $this->input->get('query');

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset

		if ($query) {
			// Jika ada query pencarian, hitung total hasil pencarian
			$config['total_rows'] = $this->Mahasiswa_model->count_search_results($query);
			$data['mahasiswa'] = $this->Mahasiswa_model->search_mahasiswa($query, $config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/mahasiswa?query=' . urlencode($query)); // Menyertakan query dalam URL
		} else {
			// Jika tidak ada pencarian, hitung total dosen
			$config['total_rows'] = $this->Mahasiswa_model->count_all_mahasiswa();
			$data['mahasiswa'] = $this->Mahasiswa_model->get_mahasiswa_paginated($config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/mahasiswa'); // Base URL untuk pagination
		}

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		// Inisialisasi pagination
		$this->pagination->initialize($config);

		// Mengambil pagination links
		$data['pagination'] = $this->pagination->create_links();

		// Menyimpan offset untuk digunakan dalam nomor urut
		$data['offset'] = $offset;

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-view', $data);
		$this->load->view('footer-template-view');
	}

	public function mahasiswa_edit($id_mahasiswa)
	{
		$data['mahasiswa'] = $this->Mahasiswa_model->get_mahasiswa_by_id($id_mahasiswa); // Mengambil data mahasiswa sebagai objek
		if (!$data['mahasiswa']) {
			$this->session->set_flashdata('error', 'Mahasiswa tidak ditemukan.');
			redirect('dashboard/mahasiswa');
		}
		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-view', $data); // Memuat view dengan data mahasiswa
		$this->load->view('footer-template-view');
	}

	public function update_mahasiswa()
	{
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		$data = [
			'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
			'nim' => $this->input->post('nim'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'jurusan' => $this->input->post('jurusan'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat')
		];
		$this->Mahasiswa_model->update_mahasiswa($id_mahasiswa, $data); // Memperbarui data mahasiswa
		$this->session->set_flashdata('success', 'Data mahasiswa berhasil diperbarui.');
		redirect('dashboard/mahasiswa'); // Redirect ke halaman mahasiswa setelah update
	}

	public function mahasiswa_detail($id_mahasiswa)
	{
		$data['mahasiswa'] = $this->Mahasiswa_model->get_mahasiswa_by_id($id_mahasiswa); // Mengambil data mahasiswa berdasarkan ID
		if (!$data['mahasiswa']) {
			$this->session->set_flashdata('error', 'Mahasiswa tidak ditemukan.');
			redirect('dashboard/mahasiswa');
		}

		$data['title'] = 'Mahasiswa Detail';
		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-detail-view', $data); // Memuat view detail mahasiswa
		$this->load->view('footer-template-view');
	}

	public function mahasiswa_hapus($id_mahasiswa)
	{
		$this->Mahasiswa_model->delete_mahasiswa($id_mahasiswa); // Menghapus data mahasiswa
		$this->session->set_flashdata('success', 'Data mahasiswa berhasil dihapus.');
		redirect('dashboard/mahasiswa'); // Redirect ke halaman mahasiswa setelah hapus
	}

	public function mahasiswa_tambah()
	{
		$data['title'] = 'Tambah Mahasiswa';
		// Pastikan tidak ada variabel yang tidak didefinisikan
		$data['mahasiswa'] = []; // Inisialisasi variabel mahasiswa jika diperlukan
		$data['no'] = 0; // Inisialisasi nomor urut jika diperlukan

		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-tambah-view', $data); // Memuat view untuk form tambah mahasiswa
		$this->load->view('footer-template-view');
	}

	public function print_mahasiswa()
	{
		$data['mahasiswa'] = $this->Mahasiswa_model->get_all_mahasiswa(); // Ambil semua data mahasiswa
		$this->load->view('mahasiswa-print-view', $data); // Muat view untuk cetak
	}

	public function print_dosen()
	{
		$data['dosen'] = $this->Dosen_model->get_all_dosen(); // Ambil semua data mahasiswa
		$this->load->view('dosen-print-view', $data); // Muat view untuk cetak
	}

	public function print_matakuliah()
	{
		$data['matakuliah'] = $this->Matakuliah_model->get_all_matakuliah(); // Ambil semua data mahasiswa
		$this->load->view('matakuliah-print-view', $data); // Muat view untuk cetak
	}

	public function print_registrasi()
	{
		$data['registrasi'] = $this->Registration_model->get_all_registrasi(); // Ambil semua data mahasiswa
		$this->load->view('registrasi-print-view', $data); // Muat view untuk cetak
	}

	public function print_laporan()
	{
		$data['title'] = 'Laporan Matakuliah';

		// Ambil query pencarian jika ada
		$query = $this->input->get('query');

		if ($query) {
			// Jika ada query pencarian, ambil data hasil pencarian
			$data['matakuliah_report'] = $this->Laporan_model->search_matakuliah($query);
		} else {
			// Jika tidak ada pencarian, ambil data laporan matakuliah
			$data['matakuliah_report'] = $this->Laporan_model->get_matakuliah_report();
		}

		// Muat view untuk cetak
		$this->load->view('laporan-print-view', $data);
	}



	public function save_mahasiswa()
	{
		// Mengambil data dari form
		$data = [
			'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
			'nim' => $this->input->post('nim'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'jurusan' => $this->input->post('jurusan'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat')
		];

		// Menyimpan data ke database
		if ($this->Mahasiswa_model->add_mahasiswa($data)) {
			$this->session->set_flashdata('success', 'Data mahasiswa berhasil ditambahkan.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan data mahasiswa.');
		}

		// Redirect ke halaman daftar mahasiswa setelah menyimpan
		redirect('dashboard/mahasiswa');
	}


	public function mahasiswa_search($offset = 0)
	{
		$query = $this->input->get('query'); // Mengambil query pencarian dari input
		$data['title'] = 'Pencarian Mahasiswa';

		// Mengambil offset dari URL
		$offset = $this->input->get('page') ? $this->input->get('page') : 0; // Mengambil offset dari URL

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset
		$config['base_url'] = site_url('dashboard/mahasiswa_search?query=' . urlencode($query)); // Base URL untuk pagination
		$config['page_query_string'] = TRUE; // Menggunakan query string untuk pagination
		$config['query_string_segment'] = 'page'; // Nama parameter untuk page
		// Hitung total hasil pencarian
		$total_results = $this->Mahasiswa_model->count_search_results($query);
		$config['total_rows'] = $total_results; // Total hasil pencarian

		// Mengambil data dosen berdasarkan pencarian dan offset
		$data['mahasiswa'] = $this->Mahasiswa_model->search_mahasiswa($query, $config['per_page'], $offset);

		// Kirim total_results ke view
		$data['total_results'] = $total_results; // Menyimpan total_results untuk digunakan di view

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];


		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $offset; // Menyimpan offset untuk digunakan dalam nomor urut

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('mahasiswa-view', $data);
		$this->load->view('footer-template-view');
	}






	public function dosen($offset = 0)
	{
		$data['title'] = 'Dosen';

		// Ambil query pencarian jika ada
		$query = $this->input->get('query');

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset

		if ($query) {
			// Jika ada query pencarian, hitung total hasil pencarian
			$config['total_rows'] = $this->Dosen_model->count_search_results($query);
			$data['dosen'] = $this->Dosen_model->search_dosen($query, $config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/dosen?query=' . urlencode($query)); // Menyertakan query dalam URL
		} else {
			// Jika tidak ada pencarian, hitung total dosen
			$config['total_rows'] = $this->Dosen_model->count_all_dosen();
			$data['dosen'] = $this->Dosen_model->get_dosen_paginated($config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/dosen'); // Base URL untuk pagination
		}

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		// Inisialisasi pagination
		$this->pagination->initialize($config);

		// Mengambil pagination links
		$data['pagination'] = $this->pagination->create_links();

		// Menyimpan offset untuk digunakan dalam nomor urut
		$data['offset'] = $offset;

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('dosen-view', $data);
		$this->load->view('footer-template-view');
	}

	public function dosen_tambah()
	{
		$data['title'] = 'Tambah Dosen';
		$this->load->view('header-template-view');
		$this->load->view('dosen-tambah-view', $data);
		$this->load->view('footer-template-view');
	}

	public function save_dosen()
	{
		$data = [
			'nama_dosen' => $this->input->post('nama_dosen'),
			'nip' => $this->input->post('nip'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat'),
			'jurusan' => $this->input->post('jurusan')
		];

		if ($this->Dosen_model->add_dosen($data)) {
			$this->session->set_flashdata('success', 'Data dosen berhasil ditambahkan.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan data dosen.');
		}

		redirect('dashboard/dosen'); // Redirect ke halaman daftar dosen setelah menyimpan
	}

	public function dosen_edit($id_dosen)
	{
		$data['dosen'] = $this->Dosen_model->get_dosen_by_id($id_dosen); // Mengambil data dosen berdasarkan ID
		if (!$data['dosen']) {
			$this->session->set_flashdata('error', 'Dosen tidak ditemukan.');
			redirect('dashboard/dosen');
		}
		$data['title'] = 'Edit Dosen';
		$this->load->view('header-template-view');
		$this->load->view('dosen-edit-view', $data); // Memuat view untuk form edit dosen
		$this->load->view('footer-template-view');
	}

	public function update_dosen()
	{
		$id_dosen = $this->input->post('id_dosen');
		$data = [
			'nama_dosen' => $this->input->post('nama_dosen'),
			'nip' => $this->input->post('nip'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat'),
			'jurusan' => $this->input->post('jurusan')
		];

		$this->Dosen_model->update_dosen($id_dosen, $data); // Memperbarui data dosen
		$this->session->set_flashdata('success', 'Data dosen berhasil diperbarui.');
		redirect('dashboard/dosen'); // Redirect ke halaman dosen setelah update
	}

	public function dosen_detail($id_dosen)
	{
		$data['dosen'] = $this->Dosen_model->get_dosen_by_id($id_dosen); // Mengambil data dosen berdasarkan ID
		if (!$data['dosen']) {
			$this->session->set_flashdata('error', 'Dosen tidak ditemukan.');
			redirect('dashboard/dosen');
		}

		$data['title'] = 'Detail Dosen';
		$this->load->view('header-template-view');
		$this->load->view('dosen-detail-view', $data); // Memuat view detail dosen
		$this->load->view('footer-template-view');
	}

	public function dosen_hapus($id_dosen)
	{
		$this->Dosen_model->delete_dosen($id_dosen); // Menghapus data dosen
		$this->session->set_flashdata('success', 'Data dosen berhasil dihapus.');
		redirect('dashboard/dosen'); // Redirect ke halaman dosen setelah hapus
	}

	public function dosen_search($offset = 0)
	{
		$query = $this->input->get('query'); // Mengambil query pencarian dari input
		$data['title'] = 'Pencarian Dosen';

		// Mengambil offset dari URL
		$offset = $this->input->get('page') ? $this->input->get('page') : 0; // Mengambil offset dari URL

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset
		$config['base_url'] = site_url('dashboard/dosen_search?query=' . urlencode($query)); // Base URL untuk pagination
		$config['page_query_string'] = TRUE; // Menggunakan query string untuk pagination
		$config['query_string_segment'] = 'page'; // Nama parameter untuk page
		// Hitung total hasil pencarian
		$total_results = $this->Dosen_model->count_search_results($query);
		$config['total_rows'] = $total_results; // Total hasil pencarian

		// Mengambil data dosen berdasarkan pencarian dan offset
		$data['dosen'] = $this->Dosen_model->search_dosen($query, $config['per_page'], $offset);

		// Kirim total_results ke view
		$data['total_results'] = $total_results; // Menyimpan total_results untuk digunakan di view

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];


		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $offset; // Menyimpan offset untuk digunakan dalam nomor urut

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('dosen-view', $data);
		$this->load->view('footer-template-view');
	}






	public function matakuliah($offset = 0)
	{
		$data['title'] = 'Matakuliah';

		// Ambil query pencarian jika ada
		$query = $this->input->get('query');

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset

		if ($query) {
			// Jika ada query pencarian, hitung total hasil pencarian
			$config['total_rows'] = $this->Matakuliah_model->count_search_results($query);
			$data['matakuliah'] = $this->Matakuliah_model->search_matakuliah($query, $config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/matakuliah?query=' . urlencode($query)); // Menyertakan query dalam URL
		} else {
			// Jika tidak ada pencarian, hitung total dosen
			$config['total_rows'] = $this->Matakuliah_model->count_all_matakuliah();
			$data['matakuliah'] = $this->Matakuliah_model->get_matakuliah_paginated($config['per_page'], $offset);
			$config['base_url'] = site_url('dashboard/matakuliah'); // Base URL untuk pagination
		}

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		// Inisialisasi pagination
		$this->pagination->initialize($config);

		// Mengambil pagination links
		$data['pagination'] = $this->pagination->create_links();

		// Menyimpan offset untuk digunakan dalam nomor urut
		$data['offset'] = $offset;

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-view', $data);
		$this->load->view('footer-template-view');
	}

	public function matakuliah_edit($id_matakuliah)
	{
		$data['matakuliah'] = $this->Matakuliah_model->get_matakuliah_by_id($id_matakuliah); // Mengambil data matakuliah sebagai objek
		if (!$data['matakuliah']) {
			$this->session->set_flashdata('error', 'Matakuliah tidak ditemukan.');
			redirect('dashboard/matakuliah');
		}
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-view', $data); // Memuat view dengan data matakuliah
		$this->load->view('footer-template-view');
	}

	public function update_matakuliah()
	{
		$id_matakuliah = $this->input->post('id_matakuliah');
		$data = [
			'kode_matakuliah' => $this->input->post('kode_matakuliah'),
			'nama_matakuliah' => $this->input->post('nama_matakuliah'),
			'sks' => $this->input->post('sks'),
			'jurusan' => $this->input->post('jurusan')
		];
		$this->Matakuliah_model->update_matakuliah($id_matakuliah, $data); // Memperbarui data matakuliah
		$this->session->set_flashdata('success', 'Data matakuliah berhasil diperbarui.');
		redirect('dashboard/matakuliah'); // Redirect ke halaman matakuliah setelah update
	}

	public function matakuliah_detail($id_matakuliah)
	{
		$data['matakuliah'] = $this->Matakuliah_model->get_matakuliah_by_id($id_matakuliah); // Mengambil data matakuliah berdasarkan ID
		if (!$data['matakuliah']) {
			$this->session->set_flashdata('error', 'Matakuliah tidak ditemukan.');
			redirect('dashboard/matakuliah');
		}

		$data['title'] = 'Detail Matakuliah';
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-detail-view', $data); // Memuat view detail matakuliah
		$this->load->view('footer-template-view');
	}

	public function matakuliah_hapus($id_matakuliah)
	{
		$this->Matakuliah_model->delete_matakuliah($id_matakuliah); // Menghapus data matakuliah
		$this->session->set_flashdata('success', 'Data matakuliah berhasil dihapus.');
		redirect('dashboard/matakuliah'); // Redirect ke halaman matakuliah setelah hapus
	}

	public function matakuliah_tambah()
	{
		$data['title'] = 'Tambah Matakuliah';
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-tambah-view', $data); // Memuat view untuk form tambah matakuliah
		$this->load->view('footer-template-view');
	}

	public function save_matakuliah()
	{
		// Mengambil data dari form
		$data = [
			'kode_matakuliah' => $this->input->post('kode_matakuliah'),
			'nama_matakuliah' => $this->input->post('nama_matakuliah'),
			'sks' => $this->input->post('sks'),
			'jurusan' => $this->input->post('jurusan')
		];

		// Menyimpan data ke database
		if ($this->Matakuliah_model->add_matakuliah($data)) {
			$this->session->set_flashdata('success', 'Data matakuliah berhasil ditambahkan.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan data matakuliah.');
		}

		// Redirect ke halaman daftar matakuliah setelah menyimpan
		redirect('dashboard/matakuliah');
	}

	public function matakuliah_search($offset = 0)
	{
		$query = $this->input->get('query'); // Mengambil query pencarian dari input
		$data['title'] = 'Pencarian Matakuliah';

		// Mengambil offset dari URL
		$offset = $this->input->get('page') ? $this->input->get('page') : 0; // Mengambil offset dari URL

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset
		$config['base_url'] = site_url('dashboard/matakuliah_search?query=' . urlencode($query)); // Base URL untuk pagination
		$config['page_query_string'] = TRUE; // Menggunakan query string untuk pagination
		$config['query_string_segment'] = 'page'; // Nama parameter untuk page
		// Hitung total hasil pencarian
		$total_results = $this->Matakuliah_model->count_search_results($query);
		$config['total_rows'] = $total_results; // Total hasil pencarian

		// Mengambil data dosen berdasarkan pencarian dan offset
		$data['matakuliah'] = $this->Matakuliah_model->search_matakuliah($query, $config['per_page'], $offset);

		// Kirim total_results ke view
		$data['total_results'] = $total_results; // Menyimpan total_results untuk digunakan di view

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];


		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $offset; // Menyimpan offset untuk digunakan dalam nomor urut

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('matakuliah-view', $data);
		$this->load->view('footer-template-view');
	}







	public function kelola_pendaftaran($offset = 0)
	{
		$data['title'] = 'Kelola Pendaftaran';

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset

		// Hitung total pendaftaran
		$config['total_rows'] = $this->Registration_model->count_all_registrations();
		$data['registrations'] = $this->Registration_model->get_registrations_paginated($config['per_page'], $offset);
		$config['base_url'] = site_url('dashboard/kelola_pendaftaran'); // Base URL untuk pagination

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		// Inisialisasi pagination
		$this->pagination->initialize($config);

		// Mengambil pagination links
		$data['pagination'] = $this->pagination->create_links();

		// Menyimpan offset untuk digunakan dalam nomor urut
		$data['offset'] = $offset;

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('registrasi-view', $data); // Tampilkan view untuk kelola pendaftaran
		$this->load->view('footer-template-view');
	}

	public function registrasi_tambah()
	{
		$data['title'] = 'Tambah Pendaftaran';
		// Ambil data mahasiswa, dosen, dan matakuliah untuk dropdown
		$data['mahasiswa'] = $this->Registration_model->get_all_mahasiswa();
		$data['dosen'] = $this->Registration_model->get_all_dosen();
		$data['matakuliah'] = $this->Registration_model->get_all_matakuliah();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('registrasi-tambah-view', $data); // Pastikan nama view sesuai
		$this->load->view('footer-template-view');
	}

	public function save_registration()
	{
		// Mengambil data dari form
		$data = [
			'id_mahasiswa' => $this->input->post('id_mahasiswa'),
			'id_dosen' => $this->input->post('id_dosen'),
			'id_matakuliah' => $this->input->post('id_matakuliah'),
			'semester' => $this->input->post('semester'),
			'tahun_ajaran' => $this->input->post('tahun_ajaran'), // Perbaiki spasi di sini
		];

		// Menyimpan data pendaftaran
		$insert = $this->Registration_model->insert_registration($data);

		// Cek apakah penyimpanan berhasil
		if ($insert) {
			// Set flashdata untuk sukses
			$this->session->set_flashdata('success', 'Pendaftaran berhasil ditambahkan.');
		} else {
			// Set flashdata untuk gagal
			$this->session->set_flashdata('error', 'Pendaftaran gagal ditambahkan. Silakan coba lagi.');
		}

		redirect('dashboard/kelola_pendaftaran'); // Kembali ke halaman kelola pendaftaran setelah menyimpan
	}

	public function registrasi_edit($id)
	{
		// Memuat model
		$data['title'] = 'Edit Pendaftaran';
		$this->load->model('Registration_model');

		// Ambil data registrasi berdasarkan ID
		$data['registrasi'] = $this->Registration_model->get_registration_by_id($id);

		// Ambil data mahasiswa, dosen, dan matakuliah untuk dropdown
		$data['mahasiswa'] = $this->Registration_model->get_all_mahasiswa();
		$data['dosen'] = $this->Registration_model->get_all_dosen();
		$data['matakuliah'] = $this->Registration_model->get_all_matakuliah();

		// Kirim data ke view
		$this->load->view('header-template-view');
		$this->load->view('registrasi-edit-view', $data);
		$this->load->view('footer-template-view');
	}

	public function update_registration()
	{
		// Ambil data dari POST
		$id_registrasi = $this->input->post('id_registrasi');
		$id_mahasiswa = $this->input->post('id_mahasiswa');
		$id_dosen = $this->input->post('id_dosen');
		$id_matakuliah = $this->input->post('id_matakuliah');
		$semester = $this->input->post('semester');
		$tahun_ajaran = $this->input->post('tahun_ajaran');

		// Lakukan update di database
		$data = [
			'id_mahasiswa' => $id_mahasiswa,
			'id_dosen' => $id_dosen,
			'id_matakuliah' => $id_matakuliah,
			'semester' => $semester,
			'tahun_ajaran' => $tahun_ajaran
		];

		$this->db->where('id_registrasi', $id_registrasi);
		$update = $this->db->update('registrasi', $data);

		// Cek apakah update berhasil
		if ($update) {
			// Set flashdata untuk sukses
			$this->session->set_flashdata('success', 'Pendaftaran berhasil diperbarui.');
		} else {
			// Set flashdata untuk gagal
			$this->session->set_flashdata('error', 'Pendaftaran gagal diperbarui. Silakan coba lagi.');
		}

		// Redirect ke halaman kelola pendaftaran
		redirect('dashboard/kelola_pendaftaran');
	}

	public function registrasi_hapus($id)
	{
		// Menghapus pendaftaran berdasarkan ID
		$this->Registration_model->delete_registration($id);
		redirect('dashboard/kelola_pendaftaran'); // Kembali ke halaman kelola pendaftaran setelah menghapus
	}
	public function registrasi_detail($id)
	{
		$data['title'] = 'Detail Pendaftaran';

		// Ambil data registrasi berdasarkan ID
		$data['registrasi'] = $this->Registration_model->get_registrasi_by_id($id);

		// Cek apakah data registrasi ditemukan
		if (!$data['registrasi']) {
			// Jika tidak ditemukan, redirect atau tampilkan pesan error
			show_404(); // Atau bisa menggunakan flashdata untuk pesan error
		}

		// Memuat view untuk detail pendaftaran
		$this->load->view('header-template-view');
		$this->load->view('registrasi-detail-view', $data); // Tampilkan view untuk detail pendaftaran
		$this->load->view('footer-template-view');
	}
	public function registrasi_search($offset = 0)
	{
		// Mengambil query pencarian dari input
		$query = $this->input->get('query');
		$semester = $this->input->get('semester'); // Mengambil semester dari input
		$tahun_ajaran = $this->input->get('tahun_ajaran'); // Mengambil tahun ajaran dari input
		$data['title'] = 'Pencarian Pendaftaran';

		// Mengambil offset dari URL
		$offset = $this->input->get('page') ? $this->input->get('page') : 0; // Mengambil offset dari URL

		// Konfigurasi pagination
		$config['per_page'] = 10; // Jumlah data per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk offset
		$config['base_url'] = site_url('dashboard/registrasi_search?query=' . urlencode($query) . '&semester=' . urlencode($semester) . '&tahun_ajaran=' . urlencode($tahun_ajaran)); // Base URL untuk pagination
		$config['page_query_string'] = TRUE; // Menggunakan query string untuk pagination
		$config['query_string_segment'] = 'page'; // Nama parameter untuk page

		// Hitung total hasil pencarian
		$total_results = $this->Registration_model->count_search_results($query, $semester, $tahun_ajaran);
		$config['total_rows'] = $total_results; // Total hasil pencarian

		// Mengambil data pendaftaran berdasarkan pencarian dan offset
		$data['registrations'] = $this->Registration_model->search_registrations($query, $config['per_page'], $offset, $semester, $tahun_ajaran);

		// Kirim total_results ke view
		$data['total_results'] = $total_results; // Menyimpan total_results untuk digunakan di view

		// Customisasi pagination
		$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '<i class="tf-icon bx bx-chevrons-left"></i>';
		$config['first_tag_open'] = '<li class="page-item first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="tf-icon bx bx-chevrons-right"></i>';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="tf-icon bx bx-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="tf-icon bx bx-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		// Inisialisasi pagination
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $offset; // Menyimpan offset untuk digunakan dalam nomor urut

		// Memuat view
		$this->load->view('header-template-view');
		$this->load->view('registrasi-view', $data); // Pastikan view ini sesuai dengan data pendaftaran
		$this->load->view('footer-template-view');
	}




	public function laporan()
	{
		$data['title'] = 'Laporan Matakuliah';

		// Ambil query pencarian jika ada
		$query = $this->input->get('query');

		if ($query) {
			// Jika ada query pencarian, ambil data hasil pencarian
			$data['matakuliah_report'] = $this->Laporan_model->search_matakuliah($query); // Pastikan Anda memiliki metode ini di model
		} else {
			// Jika tidak ada pencarian, ambil data laporan matakuliah
			$data['matakuliah_report'] = $this->Laporan_model->get_matakuliah_report(); // Ambil data laporan matakuliah
		}

		// Load view
		$this->load->view('header-template-view');
		$this->load->view('laporan-view', $data);
		$this->load->view('footer-template-view');
	}


}
?>