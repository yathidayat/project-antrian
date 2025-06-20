<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
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
            z-index: 1;
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

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            font-weight: bold;
            height: 40px;
            position: fixed;
            bottom: 0;
            left: 0;
        }



        .footer p {
            margin: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            padding-bottom: 60px;
            /* Jarak untuk footer */
            transition: 0.3s;
        }

        .navbar {
            margin-left: 250px;
            transition: 0.3s;
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
        }

        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
            }
        }
    </style>
</head>

<body>

    <button class="btn btn-dark sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>

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
            <h2>Laporan Bulanan</h2>
            <form id="formLaporan" action="<?= site_url('dashboard/cetak_laporan') ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bulan" class="form-label">Pilih Bulan:</label>
                        <select class="form-select" name="bulan" id="bulan" required>
                            <option value="" disabled selected>Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Pilih Tahun:</label>
                        <select class="form-select" name="tahun" id="tahun" required>
                            <option value="" disabled selected>Pilih Tahun</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cetak Laporan</button>
            </form>
        </div>
    </div>


    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>Hak Cipta © 2024 Muhammad Hidayat-310123023780 STMIK BANJARBARU. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Tambahkan pilihan tahun dari 2022 sampai tahun sekarang
        const yearSelect = document.getElementById('tahun');
        const currentYear = new Date().getFullYear();

        for (let year = 2022; year <= currentYear; year++) {
            let option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }

        // Handle form submit untuk AJAX request
        document.getElementById('formLaporan').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            // Ambil data form
            let formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(html => {
                    // Tampilkan laporan di halaman baru
                    let printWindow = window.open('', '', 'width=800,height=600');
                    printWindow.document.write(html);
                    printWindow.document.close();
                    printWindow.focus();
                });
        });
    </script>
</body>

</html>