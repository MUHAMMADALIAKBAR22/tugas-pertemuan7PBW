<?php
include 'db.php';

if (isset($_GET['delete'])) {
    $kodemk = $_GET['delete'];
    
    // Check if mata kuliah has KRS entries
    $check_krs = $conn->query("SELECT COUNT(*) as count FROM krs WHERE matakuliah_kodemk='$kodemk'")->fetch_assoc();
    
    if ($check_krs['count'] > 0) {
        $error_message = "Mata kuliah dengan kode $kodemk memiliki data KRS. Hapus data KRS terlebih dahulu.";
    } else {
        $conn->query("DELETE FROM matakuliah WHERE kodemk='$kodemk'");
        header("Location: matakuliah.php");
        exit;
    }
}

// Get matakuliah data with sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'kodemk';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Validate sort field
$valid_sorts = ['kodemk', 'nama', 'jumlah_sks'];
if (!in_array($sort, $valid_sorts)) {
    $sort = 'kodemk';
}

// Validate order direction
$valid_orders = ['asc', 'desc'];
if (!in_array($order, $valid_orders)) {
    $order = 'asc';
}

$result = $conn->query("SELECT * FROM matakuliah ORDER BY $sort $order");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, #2d8f85 0%, #185a54 100%);
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
            background-color: #2d8f85;
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
        .sort-link {
            color: white;
            text-decoration: none;
        }
        .sort-link:hover {
            color: #f0f0f0;
            text-decoration: underline;
        }
        .sks-badge {
            background-color: #2d8f85;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            color: white;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-book-fill"></i> Data Mata Kuliah</h2>
            <p class="lead">Manajemen data mata kuliah dan SKS</p>
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
                <a href="matakuliah_tambah.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
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
                                    <th scope="col">
                                        <a href="?sort=kodemk&order=<?= $sort == 'kodemk' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                                           class="sort-link">
                                            Kode MK
                                            <?php if($sort == 'kodemk'): ?>
                                                <i class="bi bi-arrow-<?= $order == 'asc' ? 'up' : 'down' ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="?sort=nama&order=<?= $sort == 'nama' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                                           class="sort-link">
                                            Nama Mata Kuliah
                                            <?php if($sort == 'nama'): ?>
                                                <i class="bi bi-arrow-<?= $order == 'asc' ? 'up' : 'down' ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="?sort=jumlah_sks&order=<?= $sort == 'jumlah_sks' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                                           class="sort-link">
                                            SKS
                                            <?php if($sort == 'jumlah_sks'): ?>
                                                <i class="bi bi-arrow-<?= $order == 'asc' ? 'up' : 'down' ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col" width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong><?= $row['kodemk'] ?></strong></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><span class="sks-badge"><?= $row['jumlah_sks'] ?> SKS</span></td>
                                    <td>
                                        <a href="matakuliah_edit.php?kodemk=<?= $row['kodemk'] ?>" class="btn btn-sm btn-warning btn-action">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="matakuliah.php?delete=<?= $row['kodemk'] ?>" class="btn btn-sm btn-danger btn-action" 
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
                        <p>Belum ada data mata kuliah. Silakan tambahkan data baru.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer class="mt-5 py-3 text-center text-muted">
        <div class="container">
            <small>&copy; ini punya ali</small>
        </div>
    </footer