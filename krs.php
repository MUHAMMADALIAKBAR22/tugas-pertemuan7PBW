<?php
include 'db.php';

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM krs WHERE id=$id");
    header("Location: krs.php");
    exit;
}

// Modified query with additional ordering
$sql = "SELECT krs.id, mahasiswa.npm, mahasiswa.nama as nama_lengkap, 
        matakuliah.nama as mata_kuliah, matakuliah.kodemk,
        matakuliah.jumlah_sks
        FROM krs 
        JOIN mahasiswa ON krs.mahasiswa_npm = mahasiswa.npm 
        JOIN matakuliah ON krs.matakuliah_kodemk = matakuliah.kodemk
        ORDER BY mahasiswa.nama, matakuliah.nama";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen KRS</title>
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
        .table {
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .btn-action {
            margin: 2px;
            border-radius: 20px;
        }
        .highlight-mk {
            color: #0056b3;
            font-weight: 500;
        }
        .highlight-mhs {
            color: #dc3545;
            font-weight: 500;
        }
        .actions-column {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h2><i class="bi bi-journals"></i> Kartu Rencana Studi</h2>
            <p class="lead">Manajemen data pengambilan mata kuliah oleh mahasiswa</p>
        </div>
    </div>
    
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-house-fill"></i> Dashboard
                </a>
            </div>
            <div>
                <a href="krs_tambah.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data KRS
                </a>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="20%">Mahasiswa</th>
                                <th scope="col" width="20%">Mata Kuliah</th>
                                <th scope="col">Detail</th>
                                <th scope="col" class="actions-column">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = $result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_lengkap'] ?></td>
                                <td><?= $row['mata_kuliah'] ?></td>
                                <td>
                                    <span class="highlight-mhs"><?= $row['nama_lengkap'] ?></span> 
                                    mengambil kuliah 
                                    <span class="highlight-mk"><?= $row['mata_kuliah'] ?></span>
                                    <span class="badge bg-secondary"><?= $row['jumlah_sks'] ?> SKS</span>
                                </td>
                                <td>
                                    <a href="krs_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning btn-action">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="krs.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-action" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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