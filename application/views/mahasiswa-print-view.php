<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="<?= base_url('bootstrap/assets/'); ?>" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('bootstrap/assets//img/favicon/favicon.ico'); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets//vendor/fonts/boxicons.css'); ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/vendor/css/core.css'); ?>"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/vendor/css/theme-default.css'); ?>"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/css/demo.css'); ?>" />

  <!-- Vendors CSS -->
  <link rel="stylesheet"
    href="<?= base_url('bootstrap/assets//vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Include Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="<?= base_url('bootstrap/assets/vendor/js/helpers.js'); ?>"></script>

  <!-- Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->
  <script src="<?= base_url('bootstrap/assets/js/config.js'); ?>"></script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Data Mahasiswa</title>
  <style>
    @media print {

      /* Sembunyikan elemen yang tidak perlu saat mencetak */
      .no-print {
        display: none;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th,
      td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
      }
    }
  </style>
</head>

<body>
  <h1>Data Mahasiswa</h1>
  <table>
    <thead>
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
    <tbody>
      <?php foreach ($mahasiswa as $index => $row): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= htmlspecialchars($row->nama_mahasiswa); ?></td>
          <td><?= htmlspecialchars($row->nim); ?></td>
          <td><?= htmlspecialchars($row->tanggal_lahir); ?></td>
          <td><?= htmlspecialchars($row->jurusan); ?></td>
          <td><?= htmlspecialchars($row->email); ?></td>
          <td><?= htmlspecialchars($row->telepon); ?></td>
          <td><?= htmlspecialchars($row->alamat); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <script>
    window.print(); // Otomatis memanggil dialog print saat halaman dimuat
  </script>
</body>

</html>