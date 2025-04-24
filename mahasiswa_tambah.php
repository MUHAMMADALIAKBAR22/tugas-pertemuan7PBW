<?php
include 'db.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    
    // Validate NPM isn't empty
    if (empty($npm)) {
        $pesan = "NPM tidak boleh kosong!";
    } else {
        // Check if NPM already exists
        $check_sql = "SELECT * FROM mahasiswa WHERE npm='$npm'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $pesan = "NPM $npm sudah terdaftar. Gunakan NPM lain.";
        } else {
            // Sanitize inputs to prevent SQL injection
            $npm = mysqli_real_escape_string($conn, $npm);
            $nama = mysqli_real_escape_string($conn, $nama);
            $jurusan = mysqli_real_escape_string($conn, $jurusan);
            $alamat = mysqli_real_escape_string($conn, $alamat);
            
            $sql = "INSERT INTO mahasiswa (npm, nama, jurusan, alamat) VALUES ('$npm', '$nama', '$jurusan', '$alamat')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: mahasiswa.php");
                exit;
            } else {
                $pesan = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa Baru</title>
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
            <h2><i class="bi bi-person-plus-fill"></i> Tambah Mahasiswa Baru</h2>
            <p class="lead">Daftarkan mahasiswa baru ke sistem</p>
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
                                <label for="npm" class="form-label required-field">
                                    <i class="bi bi-person-badge"></i> NPM
                                </label>
                                <input type="text" class="form-control" id="npm" name="npm" placeholder="Contoh: 12345678" required>
                                <div class="form-text">Masukkan NPM mahasiswa yang unik</div>
                            </div>
                            <div class="mb-4">
                                <label for="nama" class="form-label required-field">
                                    <i class="bi bi-person"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap mahasiswa" required>
                            </div>
                            <div class="mb-4">
                                <label for="jurusan" class="form-label">
                                    <i class="bi bi-briefcase"></i> Program Studi
                                </label>
                                <select class="form-select" id="jurusan" name="jurusan">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <option value="Teknik Informatika">Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="alamat" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Alamat
                                </label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="mahasiswa.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-person-plus"></i> Daftarkan Mahasiswa
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