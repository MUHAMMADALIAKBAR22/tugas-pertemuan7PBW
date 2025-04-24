<?php
include 'db.php';

$pesan = '';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mahasiswa_npm = $_POST['mahasiswa_npm'];
    $matakuliah_kodemk = $_POST['matakuliah_kodemk'];
    
    $sql = "UPDATE krs SET mahasiswa_npm='$mahasiswa_npm', matakuliah_kodemk='$matakuliah_kodemk' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: krs.php");
        exit;
    } else {
        $pesan = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$krs_result = $conn->query("SELECT * FROM krs WHERE id=$id");
$krs = $krs_result->fetch_assoc();

$mhs_result = $conn->query("SELECT * FROM mahasiswa ORDER BY nama");

$mk_result = $conn->query("SELECT * FROM matakuliah ORDER BY nama");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update KRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #2b2b2b 0%, #000000 100%);
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
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-pencil-square"></i> Perbarui KRS</h2>
            <p class="lead">Edit pengambilan mata kuliah oleh mahasiswa</p>
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
                                <label for="mahasiswa_npm" class="form-label">
                                    <i class="bi bi-person"></i> Mahasiswa
                                </label>
                                <select class="form-select" id="mahasiswa_npm" name="mahasiswa_npm" required>
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    <?php while($mhs = $mhs_result->fetch_assoc()): ?>
                                    <option value="<?= $mhs['npm'] ?>" <?= $krs['mahasiswa_npm'] == $mhs['npm'] ? 'selected' : '' ?>>
                                        <?= $mhs['npm'] . ' - ' . $mhs['nama'] . ' (' . $mhs['jurusan'] . ')' ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                                <div class="form-text">Pilih mahasiswa yang akan mengambil mata kuliah</div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="matakuliah_kodemk" class="form-label">
                                    <i class="bi bi-book"></i> Mata Kuliah
                                </label>
                                <select class="form-select" id="matakuliah_kodemk" name="matakuliah_kodemk" required>
                                    <option value="">-- Pilih Mata Kuliah --</option>
                                    <?php 
                                    // Reset the result pointer
                                    $mk_result = $conn->query("SELECT * FROM matakuliah ORDER BY nama");
                                    while($mk = $mk_result->fetch_assoc()): 
                                    ?>
                                    <option value="<?= $mk['kodemk'] ?>" <?= $krs['matakuliah_kodemk'] == $mk['kodemk'] ? 'selected' : '' ?>>
                                        <?= $mk['kodemk'] . ' - ' . $mk['nama'] . ' (' . $mk['jumlah_sks'] . ' SKS)' ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                                <div class="form-text">Pilih mata kuliah yang akan diambil</div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="krs.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
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