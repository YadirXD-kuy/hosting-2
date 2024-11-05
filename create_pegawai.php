<?php include 'db.php'; 
    $sql = "SELECT * FROM pegawai";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Daftar Pegawai</title>
</head>
<body>

<div class="container" style="width: 100%; max-width: 1000px;">
    <div class="card card-body">
        <h2 class="text-center">Daftar Pegawai</h2>

        <form action="" method="POST" onsubmit="return validateForm()" class="mb-4">
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" name="nama_pegawai" placeholder="Nama Pegawai" required>
            </div>
            <div class="mb-3">
                <label for="jk_pegawai" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jk_pegawai" id="jk_pegawai" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" name="no_hp" placeholder="No HP" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Tambah Pegawai</button>
        </form>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Jenis Kelamin</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?> 
                <tr>
                    <td><?= $row['nama_pegawai'] ?></td>
                    <td><?= $row['jk_pegawai'] ?></td>
                    <td><?= $row['no_hp'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td>
                        <a href="edit_pegawai.php?id=<?= $row['id_pegawai'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_pegawai.php?id=<?= $row['id_pegawai'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary mt-3">Beranda</a>
    </div>
</div>

<script>
    function validateForm() {
        const nama_pegawai = document.querySelector('input[name="nama_pegawai"]').value;
        const no_hp = document.querySelector('input[name="no_hp"]').value;

        // Cek apakah nama pegawai diisi
        if (!nama_pegawai) {
            alert("Nama pegawai belum diisi!");
            return false;
        }

        // Cek apakah no_hp hanya berisi angka
        if (!/^\d+$/.test(no_hp)) {
            alert("Hanya bisa menggunakan angka untuk No HP");
            return false;
        }

        return true;
    }
</script>

</body>
</html>

<?php

if (isset($_POST['submit'])) {
    $nama_pegawai = $_POST['nama_pegawai'];
    $jk_pegawai = $_POST['jk_pegawai'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO pegawai (nama_pegawai, jk_pegawai, no_hp, email, alamat) 
            VALUES ('$nama_pegawai', '$jk_pegawai', '$no_hp', '$email', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>