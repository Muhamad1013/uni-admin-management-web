<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="<?= base_url('bootstrap/assets/'); ?>" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('bootstrap/assets/img/favicon/favicon.ico'); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/vendor/fonts/boxicons.css'); ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/vendor/css/core.css'); ?>"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/vendor/css/theme-default.css'); ?>"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= base_url('bootstrap/assets/css/demo.css'); ?>" />

  <!-- Page CSS -->
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

  <title>Cetak Data Registrasi</title>
</head>

<body>
  <h1>Data Registrasi</h1>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Mahasiswa</th>
        <th>Nama Dosen</th>
        <th>Nama Matakuliah</th>
        <th>Semester</th>
        <th>Tahun Ajaran</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($registrasi as $index => $row): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= htmlspecialchars($row->nama_mahasiswa); ?></td>
          <td><?= htmlspecialchars($row->nama_dosen); ?></td>
          <td><?= htmlspecialchars($row->nama_matakuliah); ?></td>
          <td><?= htmlspecialchars($row->semester); ?></td>
          <td><?= htmlspecialchars($row->tahun_ajaran); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <script>
    window.print(); // Otomatis memanggil dialog print saat halaman dimuat
  </script>
</body>

</html>