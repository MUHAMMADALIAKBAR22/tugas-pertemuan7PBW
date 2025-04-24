<?php
include 'db.php';

// Handle delete operation
if (isset($_GET['delete'])) {
    $npm = $_GET['delete'];
    
    // Check if student has KRS entries
    $check_krs = $conn->query("SELECT COUNT(*) as count FROM krs WHERE mahasiswa_npm='$npm'")->fetch_assoc();
    
    if ($check_krs['count'] > 0) {
        $error_message = "Mahasiswa dengan NPM $npm memiliki data KRS. Hapus data KRS terlebih dahulu.";
    } else {
        $conn->query("DELETE FROM mahasiswa WHERE npm='$npm'");
        header("Location: mahasiswa.php");
        exit;
    }
}

// Get mahasiswa data
$result = $conn->query("SELECT * FROM mahasiswa ORDER BY nama");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
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
        .table {
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background-color: #c31432;
            color: white;
        }
        .btn-action {
            margin: 2px;
            border-radius: 20px;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-person-lines-fill"></i> Data Mahasiswa</h2>
            <p class="lead">Pengelolaan data lengkap mahasiswa</p>
        </div>
    </div>
    
    <div class="container">
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-house-fill"></i> Dashboard
                </a>
            </div>
            <div>
                <a href="mahasiswa_tambah.php" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
                </a>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body p-0">
                <?php if($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">NPM</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Program Studi</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col" width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark"><?= $row['npm'] ?></span></td>
                                    <td><strong><?= $row['nama'] ?></strong></td>
                                    <td>
                                        <?php if($row['jurusan']): ?>
                                            <span class="badge bg-danger"><?= $row['jurusan'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum ditentukan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['alamat'] ?: '<em class="text-muted">Tidak ada alamat</em>' ?></td>
                                    <td>
                                        <a href="mahasiswa_edit.php?npm=<?= $row['npm'] ?>" class="btn btn-sm btn-warning btn-action">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="mahasiswa.php?delete=<?= $row['npm'] ?>" class="btn btn-sm btn-danger btn-action" 
                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="bi bi-info-circle-fill fs-3"></i>
                        <p>Belum ada data mahasiswa. Silakan tambahkan data baru.</p>
                    </div>
                <?php endif; ?>
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