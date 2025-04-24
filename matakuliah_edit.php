<?php
include 'db.php';

$pesan = '';
$kodemk = $_GET['kodemk'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jumlah_sks = $_POST['jumlah_sks'];
    
    $sql = "UPDATE matakuliah SET nama='$nama', jumlah_sks=$jumlah_sks WHERE kodemk='$kodemk'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: matakuliah.php");
        exit;
    } else {
        $pesan = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM matakuliah WHERE kodemk='$kodemk'");
$matakuliah = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Data Mata Kuliah</h2>
        
        <?php if($pesan != ''): ?>
            <div class="alert alert-danger"><?= $pesan ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="kodemk" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kodemk" value="<?= $matakuliah['kodemk'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $matakuliah['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_sks" class="form-label">Jumlah SKS</label>
                <input type="number" class="form-control" id="jumlah_sks" name="jumlah_sks" value="<?= $matakuliah['jumlah_sks'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="matakuliah.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>