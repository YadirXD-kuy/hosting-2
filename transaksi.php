<?php
include 'db.php';

$pegawaiQuery = "SELECT id_pegawai, nama_pegawai FROM pegawai";
$pegawaiResult = mysqli_query($conn, $pegawaiQuery);
$anggotaQuery = "SELECT id_anggota, nama_anggota, saldo_anggota FROM anggota";
$anggotaResult = mysqli_query($conn, $anggotaQuery);

if (isset($_POST['create'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $id_anggota = $_POST['id_anggota'];
    $nominal = $_POST['nominal'];
    $status_transaksi = $_POST['status_transaksi'];
    $tanggal = date('Y-m-d');

    // Query untuk menambahkan transaksi
    $sql = "INSERT INTO transaksi (id_pegawai, id_anggota, status_transaksi, nominal, tanggal) 
            VALUES ('$id_pegawai', '$id_anggota', '$status_transaksi', '$nominal', '$tanggal')";

    if (mysqli_query($conn, $sql)) {
        // Mengambil saldo saat ini dari anggota berdasarkan id_anggota
        $saldoQuery = "SELECT saldo_anggota FROM anggota WHERE id_anggota = '$id_anggota'";
        $saldoResult = mysqli_query($conn, $saldoQuery);
        $row = mysqli_fetch_assoc($saldoResult);

        if ($row) {
            $saldo_anggota = $row['saldo_anggota'];

            // Memperbarui saldo anggota sesuai status transaksi
            if ($status_transaksi === "berhasil") {
                $saldo_anggota_baru = $saldo_anggota + $nominal;
            } elseif ($status_transaksi === "tarik") {
                $saldo_anggota_baru = $saldo_anggota - $nominal;
                if ($saldo_anggota_baru < 0) {
                    echo "Saldo tidak mencukupi untuk penarikan!";
                    exit;
                }
            } else {
                $saldo_anggota_baru = $saldo_anggota;
            }

            if ($status_transaksi !== "gagal") {
                $updateSaldoQuery = "UPDATE anggota SET saldo_anggota = '$saldo_anggota_baru' WHERE id_anggota = '$id_anggota'";
                mysqli_query($conn, $updateSaldoQuery);
            }
        }
        header('Location: transaksi.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT transaksi.id_transaksi, pegawai.nama_pegawai, anggota.nama_anggota, anggota.saldo_anggota, transaksi.status_transaksi, transaksi.nominal, transaksi.tanggal
        FROM transaksi
        JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai
        JOIN anggota ON transaksi.id_anggota = anggota.id_anggota";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Daftar Transaksi</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Pegawai</th>
                <th>Anggota</th>
                <th>Saldo Anggota</th>
                <th>Status</th>
                <th>Nominal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($transaksi = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $transaksi['id_transaksi']; ?></td>
                <td><?php echo $transaksi['nama_pegawai']; ?></td>
                <td><?php echo $transaksi['nama_anggota']; ?></td>
                <td><?php echo $transaksi['saldo_anggota']; ?></td> <!-- Saldo anggota -->
                <td><?php echo $transaksi['status_transaksi']; ?></td>
                <td><?php echo $transaksi['nominal']; ?></td>
                <td><?php echo $transaksi['tanggal']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2 class="mt-5">Buat Transaksi</h2>
    <form action="transaksi.php" method="POST">
        <div class="mb-3">
            <select name="id_pegawai" class="form-select" required>
                <option value="">Pilih Pegawai</option>
                <?php while ($pegawai = mysqli_fetch_assoc($pegawaiResult)): ?>
                    <option value="<?= $pegawai['id_pegawai'] ?>"><?= $pegawai['nama_pegawai'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <select name="id_anggota" class="form-select" required>
                <option value="">Pilih Anggota</option>
                <?php while ($anggota = mysqli_fetch_assoc($anggotaResult)): ?>
                    <option value="<?= $anggota['id_anggota'] ?>"><?= $anggota['nama_anggota'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <select name="status_transaksi" class="form-select" required>
                <option value="berhasil">Berhasil</option>
                <option value="gagal">Gagal</option>
                <option value="tarik">Tarik</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="number" name="nominal" class="form-control" placeholder="Nominal Transaksi" required>
        </div>
        <button type="submit" name="create" class="btn btn-primary">Buat Transaksi</button>
    </form>
    
   <a href="index.php"><button type="submit" name="Home" class="btn btn-primary mt-2">Beranda</button></a> 

</div>
</body>
</html>
