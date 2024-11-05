<?php

include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM pegawai WHERE id_pegawai = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

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
    <title>Edit Pegawai</title>
</head>
<body>

<div class="container" style="width: 38rem;">
    <div class="card card-body mt-5">
        <h2 class="text-center">Edit Pegawai</h2>
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" name="nama_pegawai" placeholder="Nama Pegawai" value="<?= $row['nama_pegawai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jk_pegawai" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jk_pegawai" id="jk_pegawai" required>
                    <option value="Laki-laki" <?= $row['jk_pegawai'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $row['jk_pegawai'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" name="no_hp" placeholder="No HP" value="<?= $row['no_hp']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $row['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?= $row['alamat']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Edit Pegawai</button>
        </form>
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

if (isset($_POST['update'])) {
    $nama_pegawai = $_POST['nama_pegawai'];
    $jk_pegawai = $_POST['jk_pegawai'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE pegawai
            SET nama_pegawai = '$nama_pegawai', jk_pegawai = '$jk_pegawai', no_hp = '$no_hp', email = '$email', alamat = '$alamat'
            WHERE id_pegawai = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data pegawai berhasil diupdate.'); window.location.href='create_pegawai.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
