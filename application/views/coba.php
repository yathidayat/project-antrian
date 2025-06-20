<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
            color: #343a40;
            font-size: 1.1rem;
            transition: background-color 0.3s;
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
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #ddd;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        .sidebar .logout {
            position: absolute;
            bottom: 20px;
            width: 100%;
            left: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .navbar {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #343a40;
        }

        .card-text {
            font-size: 1.3rem;
            color: #6c757d;
            font-weight: bold;
        }

        .btn-cetak {
            font-size: 1.2rem;
            display: inline-block;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
            transition: color 0.3s, border-color 0.3s;
        }

        .btn-cetak::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(0, 123, 255, 0.2);
            transition: transform 0.5s;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            z-index: 0;
        }

        .btn-cetak:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn-cetak:hover {
            color: #fff;
            border-color: #0d6efd;
        }

        .btn-cetak span {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: none;
            }

            .content {
                margin-left: 0;
            }

            .navbar {
                margin-left: 0;
            }

            .sidebar.active {
                display: block;
            }

            .btn-toggle-sidebar {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
            }
        }

        .card-deck {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card-deck .card {
            margin: 15px;
            flex: 0 1 calc(33.333% - 30px);
            /* 3 cards per row, with space between */
        }

        @media (max-width: 992px) {
            .card-deck .card {
                flex: 0 1 calc(50% - 30px);
                /* 2 cards per row */
            }
        }

        @media (max-width: 768px) {
            .card-deck .card {
                flex: 0 1 100%;
                /* 1 card per row */
            }
        }
    </style>
</head>

<body>

    <button class="btn btn-dark btn-toggle-sidebar" id="sidebarToggle"><i class="bi bi-list"></i></button>

    <div class="sidebar" id="sidebar">
        <a href="<?= site_url('dashboard/admin') ?>"><span>Monitoring</span></a>
        <a href="<?= site_url('dashboard/pelayanan') ?>"><span>Pelayanan</span></a>

        <!-- Menu dengan dropdown untuk Data Master -->
        <a href="#dataMasterSubmenu" data-bs-toggle="collapse" class="dropdown-toggle"><span>Data Master</span></a>
        <ul class="collapse list-unstyled" id="dataMasterSubmenu">
            <li>
                <a href="<?= site_url('dashboard/pengguna') ?>"><span>Data Pengguna</span></a>
            </li>
            <li>
                <a href="<?= site_url('dashboard/pengunjung') ?>"><span>Data Pengunjung</span></a>
            </li>
            <li>
                <a href="<?= site_url('dashboard/laporan') ?>"><span>Data Laporan</span></a>
            </li>
        </ul>

        <!-- Tombol Logout di bagian bawah -->
        <a href="<?= site_url('auth/logout') ?>" class="logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
    </nav>

    <div class="content" id="content">
        <div class="container">
            <h1 class="mb-4 text-center">Pelayanan</h1>
            <p class="lead mb-4 text-center">Silahkan pilih layanan di bawah ini:</p>

            <div class="card-deck">
                <?php foreach ($loket as $l): ?>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Loket <?= $l->id ?> - <?= $l->nama_loket ?></h5>
                            <p class="card-text"><?= str_pad($l->nomor_terakhir, 3, '0', STR_PAD_LEFT) ?>-<?= strtoupper($l->kode_loket) ?></p>
                            <button class="btn btn-outline-primary btn-cetak" onclick="cetakStruk('<?= $l->kode_loket ?>', '<?= str_pad($l->nomor_terakhir + 1, 3, '0', STR_PAD_LEFT) ?>')"><span>Cetak</span></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Mapping kode loket ke nama loket
        const loketNames = {
            'H': 'Hukum',
            'P': 'Perkara',
            'U': 'Umum',
            'K': 'Kasir',
            'E': 'E-Court'
        };

        function cetakStruk(kodeLoket, nomorAntrian) {
            // Mendapatkan nama loket dari kode
            const namaLoket = loketNames[kodeLoket] || 'Unknown';

            fetch('<?= site_url('antrian/cetak_nomor') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `kode_loket=${kodeLoket}&nomor_antrian=${nomorAntrian}`
                })
                .then(response => response.text())
                .then(data => {
                    // Tampilkan struk
                    const strukHtml = `
                <html>
                <head>
                    <style>
                        @media print {
                            @page {
                                size: 58mm auto; /* Menyesuaikan lebar kertas printer thermal */
                                margin: 0;
                            }
                            body {
                                margin: 0;
                                padding: 0;
                                font-family: sans-serif;
                            }
                            .container {
                                width: 47mm; /* Menyesuaikan lebar kertas printer thermal */
                                padding: 0;
                                text-align: center;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h6>PENGADILAN TATA USAHA NEGARA BANJARMASIN</h6>
                        <p>Nomor Antrian: ${nomorAntrian}-${kodeLoket}</p>
                        <p>Loket: ${namaLoket}</p>
                        <p>Terima kasih atas kunjungan Anda</p>
                    </div>
                </body>
                </html>
            `;

                    const printWindow = window.open('', '', 'height=600,width=800');
                    printWindow.document.open();
                    printWindow.document.write(strukHtml);
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();

                    Swal.fire({
                        title: 'Cetak Struk',
                        text: data,
                        icon: 'success',
                        timer: 2000, // Mengatur waktu tampil alert (dalam milidetik)
                        showConfirmButton: false // Menghilangkan tombol konfirmasi
                    }).then(() => {
                        location.reload();
                    });
                });
        }

        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>