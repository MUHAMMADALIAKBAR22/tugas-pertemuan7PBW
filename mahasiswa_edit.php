<?php
include 'db.php';

$pesan = '';
$npm = $_GET['npm'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    
    // Sanitize inputs to prevent SQL injection
    $nama = mysqli_real_escape_string($conn, $nama);
    $jurusan = mysqli_real_escape_string($conn, $jurusan);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    
    $sql = "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', alamat='$alamat' WHERE npm='$npm'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: mahasiswa.php");
        exit;
    } else {
        $pesan = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM mahasiswa WHERE npm='$npm'");
$mahasiswa = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #c31432 0%, #8d1a35 100%);
            color: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 0 15px 15px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .form-label {
            font-weight: 500;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 15px;
        }
        .btn {
            border-radius: 10px;
            padding: 8px 20px;
        }
        .required-field::after {
            content: ' *';
            color: #c31432;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-pencil-square"></i> Edit Mahasiswa</h2>
            <p class="lead">Perbarui data mahasiswa dengan NPM: <?= $npm ?></p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4">
                        <?php if($pesan != ''): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $pesan ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="mb-4">
                                <label for="npm" class="form-label">
                                    <i class="bi bi-person-badge"></i> NPM
                                </label>
                                <input type="text" class="form-control bg-light" id="npm" value="<?= $mahasiswa['npm'] ?>" disabled>
                                <div class="form-text">NPM mahasiswa tidak dapat diubah</div>
                            </div>
                            <div class="mb-4">
                                <label for="nama" class="form-label required-field">
                                    <i class="bi bi-person"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $mahasiswa['nama'] ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="jurusan" class="form-label">
                                    <i class="bi bi-briefcase"></i> Program Studi
                                </label>
                                <select class="form-select" id="jurusan" name="jurusan">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <option value="Teknik Informatika" <?= $mahasiswa['jurusan'] == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                                    <option value="Sistem Informasi" <?= $mahasiswa['jurusan'] == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                                    <option value="Teknik Komputer" <?= $mahasiswa['jurusan'] == 'Teknik Komputer' ? 'selected' : '' ?>>Teknik Komputer</option>
                                    <option value="Manajemen Informatika" <?= $mahasiswa['jurusan'] == 'Manajemen Informatika' ? 'selected' : '' ?>>Manajemen Informatika</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="alamat" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Alamat
                                </label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"><?= $mahasiswa['alamat'] ?></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="mahasiswa.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="mt-5 py-3 text-center text-muted">
        <div class="container">
            <small>&copy; ini punya ali</small>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>