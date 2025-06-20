<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Import Bootstrap Icons -->
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
            color: #343a40;
            font-size: 1.1rem;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            transition: 0.3s;
            overflow-y: auto;
        }
        .sidebar a {
            padding: 12px 18px;
            text-decoration: none;
            font-size: 20px;
            color: #ddd;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: 0.3s;
        }
        .navbar {
            margin-left: 250px;
            transition: 0.3s;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #343a40;
            text-align: center; /* Pusatkan judul card */
        }
        .card-text {
            font-size: 1.3rem;
            color: #6c757d;
            text-align: center; /* Pusatkan teks nomor antrian */
            font-weight: bold; /* Teks nomor antrian lebih tebal */
        }
        .btn-cetak {
            font-size: 1.2rem;
            display: block;
            margin: 0 auto; /* Pusatkan tombol cetak */
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <a href="http://localhost/belajarci3/index.php/dasboard/admin"><span>Monitoring</span></a>
    <a href="http://localhost/belajarci3/index.php/dasboard/pelayanan"><span>Pelayanan</span></a>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
    </div>
</nav>

<div class="content" id="content">
    <div class="container">
        <h1 class="mb-4">Pelayanan</h1>
        <p class="lead mb-4">Silahkan pilih layanan di bawah ini:</p>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loket 1 - Kasir</h5>
                        <p class="card-text">003-K</p>
                        <button class="btn btn-primary btn-cetak" onclick="cetakStruk('003-K')">Cetak</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loket 2 - Perkara</h5>
                        <p class="card-text">087-P</p>
                        <button class="btn btn-primary btn-cetak" onclick="cetakStruk('087-P')">Cetak</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loket 3 - Hukum</h5>
                        <p class="card-text">005-H</p>
                        <button class="btn btn-primary btn-cetak" onclick="cetakStruk('005-H')">Cetak</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loket 4 - Umum</h5>
                        <p class="card-text">098-U</p>
                        <button class="btn btn-primary btn-cetak" onclick="cetakStruk('098-U')">Cetak</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loket 5 - E-court</h5>
                        <p class="card-text">078-E</p>
                        <button class="btn btn-primary btn-cetak" onclick="cetakStruk('078-E')">Cetak</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function cetakStruk(nomorAntrian) {
        alert("Mencetak struk untuk nomor antrian: " + nomorAntrian);   
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
