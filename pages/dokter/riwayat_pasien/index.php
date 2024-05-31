<?php
include_once("../../../config/conn.php");
session_start();

if (!isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poliklinik | Riwayat Pasien</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="path/to/adminlte.min.css">
  <!-- Bootstrap CSS (included with AdminLTE) -->
  <link rel="stylesheet" href="path/to/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Riwayat Pasien</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= $base_dokter; ?>">Home</a></li>
                <li class="breadcrumb-item active">Riwayat Pasien</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Riwayat Pasien</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pasien</th>
                  <th>Alamat</th>
                  <th>No. KTP</th>
                  <th>No. Telepon</th>
                  <th>No. RM</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $index = 1;
                $data = $pdo->query("SELECT * FROM pasien");
                if ($data->rowCount() == 0) {
                  echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
                } else {
                  while ($d = $data->fetch()) {
                ?>
                    <tr>
                      <td><?= $index++; ?></td>
                      <td><?= $d['nama']; ?></td>
                      <td><?= $d['alamat']; ?></td>
                      <td><?= $d['no_ktp']; ?></td>
                      <td><?= $d['no_hp']; ?></td>
                      <td><?= $d['no_rm']; ?></td>
                      <td>
                        <button data-toggle="modal" data-target="#detailModal<?= $d['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail Riwayat Pasien
                        </button>
                        <a href="riwayat.php?pasien_id=<?= $d['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-external-link"></i> Go to Another Page</a>
                      </td>
                    </tr>
                    <!-- Modal Detail Riwayat Pasien start here -->
                  <?php
                  $no = 1;
                  $pasien_id = $d['id'];
                  $data2 = $pdo->query("SELECT 
                                          p.nama AS 'nama_pasien',
                                          pr.*,
                                          d.nama AS 'nama_dokter',
                                          dpo.keluhan AS 'keluhan',
                                          GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS 'obat'
                                      FROM periksa pr
                                      LEFT JOIN daftar_poli dpo ON (pr.id_daftar_poli = dpo.id)
                                      LEFT JOIN jadwal_periksa jp ON (dpo.id_jadwal = jp.id)
                                      LEFT JOIN dokter d ON (jp.id_dokter = d.id)
                                      LEFT JOIN pasien p ON (dpo.id_pasien = p.id)
                                      LEFT JOIN detail_periksa dp ON (pr.id = dp.id_periksa)
                                      LEFT JOIN obat o ON (dp.id_obat = o.id)
                                      WHERE dpo.id_pasien = '$pasien_id'
                                      GROUP BY pr.id
                                      ORDER BY pr.tgl_periksa DESC;");
                  ?>
                  <div class="modal fade" id="detailModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $d['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="detailModalLabel<?= $d['id'] ?>">Riwayat <?= $d['nama'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <!-- Mulai Tabel -->
                          <?php if ($data2->rowCount() == 0) : ?>
                            <h5>Tidak Ditemukan Riwayat Periksa</h5>
                          <?php else : ?>
                            <div class="grid-container">
                              <div class="grid-item">No</div>
                              <div class="grid-item">Tanggal Periksa</div>
                              <div class="grid-item">Nama Pasien</div>
                              <div class="grid-item">Nama Dokter</div>
                              <div class="grid-item">Keluhan</div>
                              <div class="grid-item">Catatan</div>
                              <div class="grid-item">Obat</div>
                              <div class="grid-item">Biaya Periksa</div>
                              <?php while ($da = $data2->fetch()) : ?>
                                <div class="grid-item"><?= $no++; ?></div>
                                <div class="grid-item"><?= $da['tgl_periksa']; ?></div>
                                <div class="grid-item"><?= $da['nama_pasien']; ?></div>
                                <div class="grid-item"><?= $da['nama_dokter']; ?></div>
                                <div class="grid-item"><?= $da['keluhan']; ?></div>
                                <div class="grid-item"><?= $da['catatan']; ?></div>
                                <div class="grid-item"><?= $da['obat']; ?></div>
                                <div class="grid-item"><?= formatRupiah($da['biaya_periksa']); ?></div>
                              <?php endwhile ?>
                              <?php $no = 1; ?>
                            </div>
                          <?php endif ?>
                          <!-- Akhir dari Tabel -->
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal Detail Riwayat Pasien ends here -->
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
<?php include '../../../layouts/index.php'; ?>
