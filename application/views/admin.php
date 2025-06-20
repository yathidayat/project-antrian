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
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .footer p {
            margin: 0;
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
            <h1>Selamat Datang Admin</h1>
            <h3>Dashboard Admin</h3>

            <!-- Card untuk Statistik Pengunjung -->
            <div class="row mb-4" style="padding-top: 20px;"> <!-- Menambahkan margin bawah untuk jarak antar elemen -->
                <div class="col-md-6">
                    <div class="card" style="padding-top: 20px;"> <!-- Card dengan padding atas -->
                        <div class="card-body">
                            <h3 class="card-title">Statistik Pengunjung Harian</h3>
                            <select id="monthSelect" class="form-select mb-3"></select>
                            <canvas id="dailyVisitorsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="padding-top: 20px;"> <!-- Card dengan padding atas -->
                        <div class="card-body">
                            <h3 class="card-title">Statistik Pengunjung Bulanan</h3>
                            <select id="yearSelect" class="form-select mb-3"></select>
                            <canvas id="monthlyReportChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
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
        // Array bulan dalam bahasa Indonesia
        const monthsIndonesian = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Function to fetch data for daily visitors
        function fetchDailyVisitorsData(year, month) {
            fetch(`<?= site_url('dashboard/get_daily_visitors') ?>?year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.day);
                    const counts = data.map(item => item.count);

                    dailyVisitorsChart.data.labels = labels;
                    dailyVisitorsChart.data.datasets[0].data = counts;
                    dailyVisitorsChart.update();
                });
        }

        // Function to fetch data for monthly report
        function fetchMonthlyReportData(year) {
            fetch(`<?= site_url('dashboard/get_monthly_report') ?>?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => monthsIndonesian[new Date(item.month + '-01').getMonth()]);
                    const counts = data.map(item => item.count);

                    monthlyReportChart.data.labels = labels;
                    monthlyReportChart.data.datasets[0].data = counts;
                    monthlyReportChart.update();
                });
        }

        // Initialize chart for daily visitors
        const dailyVisitorsChart = new Chart(
            document.getElementById('dailyVisitorsChart'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Pengunjung Harian',
                        data: [],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Hari'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Jumlah Pengunjung'
                            }
                        }
                    }
                }
            }
        );

        // Initialize chart for monthly report
        const monthlyReportChart = new Chart(
            document.getElementById('monthlyReportChart'), {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Laporan Bulanan',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Jumlah'
                            }
                        }
                    }
                }
            }
        );

        // Populate year and month selects
        function populateSelects() {
            const currentYear = new Date().getFullYear();
            const startYear = currentYear - 5;
            const yearSelect = document.getElementById('yearSelect');
            const monthSelect = document.getElementById('monthSelect');

            for (let year = startYear; year <= currentYear; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearSelect.appendChild(option);
            }
            yearSelect.value = currentYear;

            for (let month = 0; month < monthsIndonesian.length; month++) {
                const option = document.createElement('option');
                option.value = month + 1;
                option.text = monthsIndonesian[month];
                monthSelect.appendChild(option);
            }
            monthSelect.value = new Date().getMonth() + 1;

            fetchDailyVisitorsData(currentYear, monthSelect.value);
            fetchMonthlyReportData(currentYear);
        }

        populateSelects();

        // Update daily visitors chart when month changes
        document.getElementById('monthSelect').addEventListener('change', function() {
            const selectedMonth = this.value;
            const selectedYear = document.getElementById('yearSelect').value;
            fetchDailyVisitorsData(selectedYear, selectedMonth);
        });

        // Update monthly report chart when year changes
        document.getElementById('yearSelect').addEventListener('change', function() {
            const selectedYear = this.value;
            fetchMonthlyReportData(selectedYear);
        });

        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>