<?php
include 'db.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodemk = $_POST['kode_mk'];
    $nama = $_POST['nama'];
    $sks = $_POST['sks'];
    
    if (empty($kodemk)) {
        $pesan = "Kode MK tidak boleh kosong!";
    } else {
        
        $check_sql = "SELECT * FROM matakuliah WHERE kodemk='$kodemk'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $pesan = "Kode MK $kodemk sudah terdaftar. Gunakan Kode MK lain.";
        } else {
            // Sanitize inputs to prevent SQL injection
            $kodemk = mysqli_real_escape_string($conn, $kodemk);
            $nama = mysqli_real_escape_string($conn, $nama);
            $sks = mysqli_real_escape_string($conn, $sks);
            
            $sql = "INSERT INTO matakuliah (kodemk, nama, sks) VALUES ('$kodemk', '$nama', '$sks')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: matakuliah.php");
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
    <title>Tambah Mata Kuliah Baru</title>
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
            <h2><i class="bi bi-book-plus-fill"></i> Tambah Mata Kuliah Baru</h2>
            <p class="lead">Daftarkan mata kuliah baru ke sistem</p>
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
                                <label for="kode_mk" class="form-label required-field">
                                    <i class="bi bi-journal-code"></i> Kode Mata Kuliah
                                </label>
                                <input type="text" class="form-control" id="kode_mk" name="kode_mk" placeholder="Contoh: IF1002" required>
                                <div class="form-text">Masukkan kode mata kuliah yang unik</div>
                            </div>
                            <div class="mb-4">
                                <label for="nama_mk" class="form-label required-field">
                                    <i class="bi bi-journal-text"></i> Nama Mata Kuliah
                                </label>
                                <input type="text" class="form-control" id="nama_mk" name="nama_mk" placeholder="Nama lengkap mata kuliah" required>
                            </div>
                            <div class="mb-4">
                                <label for="sks" class="form-label required-field">
                                    <i class="bi bi-123"></i> SKS
                                </label>
                                <select class="form-select" id="sks" name="sks" required>
                                    <option value="">-- Pilih Jumlah SKS --</option>
                                    <option value="1">1 SKS</option>
                                    <option value="2">2 SKS</option>
                                    <option value="3">3 SKS</option>
                                    <option value="4">4 SKS</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="matakuliah.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-save"></i> Simpan Mata Kuliah
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