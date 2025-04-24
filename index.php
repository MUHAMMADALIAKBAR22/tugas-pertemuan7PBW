<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik</title>
    <!-- Changed to a different Bootstrap CDN version -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
        }
        .btn {
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1 class="text-center">Portal Akademik Kampus</h1>
            <p class="text-center lead">Sistem Informasi Manajemen Data Akademik Terpadu</p>
        </div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <i class="bi bi-people-fill"></i> Data Mahasiswa
                    </div>
                    <div class="card-body">
                        <p class="card-text">Kelola data lengkap mahasiswa termasuk NPM, nama, jurusan, dan alamat.</p>
                        <div class="d-grid">
                            <a href="mahasiswa.php" class="btn btn-danger">Akses Data Mahasiswa</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <i class="bi bi-book-fill"></i> Data Mata Kuliah
                    </div>
                    <div class="card-body">
                        <p class="card-text">Kelola informasi mata kuliah seperti kode, nama, dan jumlah SKS.</p>
                        <div class="d-grid">
                            <a href="matakuliah.php" class="btn btn-warning text-dark">Akses Data Mata Kuliah</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-clipboard-data"></i> Data KRS
                    </div>
                    <div class="card-body">
                        <p class="card-text">Kelola data KRS dan pengambilan mata kuliah oleh mahasiswa.</p>
                        <div class="d-grid">
                            <a href="krs.php" class="btn btn-dark">Akses Data KRS</a>
                        </div>
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
    
    <!-- Updated Bootstrap JS version -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>