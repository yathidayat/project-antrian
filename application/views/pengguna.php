<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
            transition: 0.3s;
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
            margin-top: auto;
            /* agar footer tetap di bawah konten */
        }

        .footer p {
            margin: 0;
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

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
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
            <!-- Form Data Pengguna -->
            <h2>Data Pengguna</h2>
            <form method="post" action="<?= site_url('dashboard/update_pengguna') ?>">
                <input type="hidden" id="user_id" name="user_id" value=""> <!-- Pastikan ini akan diisi -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">--Pilih Status--</option>
                        <option value="loket1">Loket 1</option>
                        <option value="loket2">Loket 2</option>
                        <option value="loket3">Loket 3</option>
                        <option value="loket4">Loket 4</option>
                        <option value="loket5">Loket 5</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>


            <hr>

            <!-- Tabel Data Pengguna -->
            <table class="table table-bordered" id="userTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <!-- Data akan dimuat oleh AJAX -->
                </tbody>
            </table>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>Hak Cipta © 2024 Muhammad Hidayat-310123023780 STMIK BANJARBARU. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Tambahkan SweetAlert2 CDN -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable setelah data pengguna dimuat
            function loadData() {
                $.ajax({
                    url: "<?= site_url('dashboard/get_pengguna') ?>",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var userTable = '';
                        $.each(data, function(index, user) {
                            userTable += '<tr>';
                            userTable += '<td>' + (index + 1) + '</td>';
                            userTable += '<td>' + user.username + '</td>';
                            userTable += '<td>' + user.status + '</td>';
                            userTable += '<td>';
                            userTable += '<button class="btn btn-warning btn-sm edit-btn" data-id_user="' + user.id_user + '" data-username="' + user.username + '" data-status="' + user.status + '"><i class="bi bi-pencil"></i></button>';
                            userTable += ' <button class="btn btn-danger btn-sm delete-btn" data-id_user="' + user.id_user + '"><i class="bi bi-trash"></i></button>';
                            userTable += '</td>';
                            userTable += '</tr>';
                        });
                        $('#userData').html(userTable);

                        // Inisialisasi DataTable setelah data ditampilkan
                        $('#userTable').DataTable({
                            "pageLength": 5,
                            "lengthMenu": [5, 10, 15],
                            "destroy": true
                        });
                    },
                    error: function() {
                        console.log("Error dalam memuat data pengguna");
                    }
                });
            }

            // Panggil fungsi loadData untuk pertama kali
            loadData();

            // Interval untuk me-refresh data setiap 10 detik
            setInterval(loadData, 10000);

            // Fungsi untuk menampilkan data ke dalam form saat tombol edit diklik
            $(document).on('click', '.edit-btn', function() {
                var id_user = $(this).data('id_user');
                var username = $(this).data('username');
                var status = $(this).data('status');

                $('#user_id').val(id_user); // Set ID pengguna untuk update
                $('#username').val(username);
                $('#status').val(status);
                $('#password').val(''); // Kosongkan password
            });

            // Fungsi untuk mengirim form data pengguna
            $('form').on('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman form secara default

                $.ajax({
                    url: "<?= site_url('dashboard/update_pengguna') ?>",
                    type: "POST",
                    data: $(this).serialize(), // Mengirim data form melalui AJAX
                    success: function(response) {
                        // Tampilkan SweetAlert2 saat edit berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            showConfirmButton: false,
                            timer: 2000 // Tampilkan selama 2 detik
                        });

                        setTimeout(function() {
                            location.reload(); // Muat ulang data pengguna setelah berhasil diupdate
                        }, 2000); // Jeda selama 2 detik
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat memperbarui data pengguna.',
                            'error'
                        );
                    }
                });
            });

            // Fungsi untuk menghapus data saat tombol delete diklik
            $(document).on('click', '.delete-btn', function() {
                var id_user = $(this).data('id_user');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= site_url('dashboard/hapus_pengguna') ?>",
                            type: "POST",
                            data: {
                                user_id: id_user
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pengguna berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 2000 // Tampilkan selama 2 detik
                                });
                                setTimeout(function() {
                                    location.reload(); // Muat ulang halaman setelah jeda
                                }, 2000);
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus pengguna.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>