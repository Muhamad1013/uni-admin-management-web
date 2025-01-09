<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="text-center"><?= $title ?></h1>
    <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th>Kode Matakuliah</th>
          <th>Nama Matakuliah</th>
          <th>Dosen</th>
          <th>Jumlah Mahasiswa</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($matakuliah_report as $index => $report): ?>
          <tr>
            <td class="text-center"><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($report->kode_matakuliah) ?></td>
            <td><?= htmlspecialchars($report->nama_matakuliah) ?></td>
            <td><?= htmlspecialchars($report->nama_dosen) ?></td>
            <td><?= htmlspecialchars($report->jumlah_mahasiswa) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>