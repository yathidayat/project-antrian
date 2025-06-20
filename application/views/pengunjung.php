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
            <h2>Data Pengunjung</h2>

            <!-- Tabel Data Pengguna -->
            <table class="table table-bordered" id="userTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nomor WhatsApp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Pendidikan</th>
                        <th>Keperluan</th>
                        <th>Foto</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <!-- Data akan dimuat oleh AJAX -->
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal Form Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Pengunjung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTamu">
                        <input type="hidden" id="id_user" name="id_user" value="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp">
                        </div>
                        <div class="mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan</label>
                            <select class="form-select" id="pendidikan" name="pendidikan">
                                <option value="">--Pilih Pendidikan Terakhir--</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <select class="form-select" id="keperluan" name="keperluan">
                                <option value="">--Apa Keperluan Anda?--</option>
                                <option value="Mengantar Surat">Mengantar Surat</option>
                                <option value="Pengaduan">Pengaduan</option>
                                <option value="INZAGE">INZAGE</option>
                                <option value="Mendaftarkan Surat Kuasa">Mendaftarkan Surat Kuasa</option>
                                <option value="Mendaftarkan Gugatan/Permohonan/Upaya Hukum">Mendaftarkan Gugatan/Permohonan/Upaya Hukum</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Mengurus Perijinan">Mengurus Perijinan</option>
                                <option value="Penawaran">Penawaran</option>
                                <option value="Lain-lain">Lain-Lain</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat data
            // Fungsi untuk mengubah datetime menjadi format hari, tanggal-bulan-tahun
            function formatDate(dateString) {
                var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                // Membuat objek Date dari string waktu
                var date = new Date(dateString);

                // Mengambil hari
                var dayName = days[date.getDay()];

                // Mengambil tanggal, bulan, dan tahun
                var day = date.getDate();
                var month = date.getMonth() + 1; // Bulan dimulai dari 0, jadi tambahkan 1
                var year = date.getFullYear();

                // Menambahkan '0' jika tanggal atau bulan kurang dari 10
                if (day < 10) {
                    day = '0' + day;
                }
                if (month < 10) {
                    month = '0' + month;
                }

                // Mengembalikan format "Hari, DD-MM-YYYY"
                return dayName + ', ' + day + '-' + month + '-' + year;
            }

            function loadData() {
                $.ajax({
                    url: "<?= site_url('dashboard/get_pengunjung') ?>",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var userTable = '';
                        $.each(data, function(index, user) {
                            userTable += '<tr>';
                            userTable += '<td>' + (index + 1) + '</td>';
                            userTable += '<td>' + user.nama + '</td>';
                            userTable += '<td>' + user.nohp + '</td>';
                            userTable += '<td>' + user.email + '</td>';
                            userTable += '<td>' + user.alamat + '</td>';
                            userTable += '<td>' + user.jenis_kelamin + '</td>';
                            userTable += '<td>' + user.pendidikan + '</td>';
                            userTable += '<td>' + user.keperluan + '</td>';
                            userTable += '<td><img src="/antrianapp/assets/pengunjung/uploads/foto_tamu/' + user.foto + '" alt="Foto Pengunjung" width="50" height="50"></td>';
                            userTable += '<td>' + formatDate(user.waktu) + '</td>';

                            userTable += '<td>';
                            userTable += '<button class="btn btn-warning btn-sm edit-btn" data-id_user="' + user.id + '" data-nama="' + user.nama + '" data-nohp="' + user.nohp + '" data-email="' + user.email + '" data-alamat="' + user.alamat + '" data-keperluan="' + user.keperluan + '" data-pendidikan="' + user.pendidikan + '"><i class="bi bi-pencil"></i></button>';
                            userTable += ' <button class="btn btn-danger btn-sm delete-btn mt-1" data-id_user="' + user.id + '"><i class="bi bi-trash"></i></button>';
                            userTable += '</td>';
                            userTable += '</tr>';
                        });
                        $('#userData').html(userTable);

                        // Cek apakah DataTable sudah diinisialisasi
                        if ($.fn.DataTable.isDataTable('#userTable')) {
                            $('#userTable').DataTable().destroy(); // Hancurkan instance DataTable sebelumnya
                        }

                        // Inisialisasi DataTable
                        $('#userTable').DataTable({
                            "pageLength": 5,
                            "lengthMenu": [5, 10, 25, 50],
                        });
                    }
                });
            }


            loadData(); // Memanggil fungsi loadData untuk menampilkan data

            // Menangani event klik pada tombol edit
            $(document).on('click', '.edit-btn', function() {
                // Ambil data dari atribut data- pada tombol edit
                var id_user = $(this).data('id_user');
                var nama = $(this).data('nama');
                var nohp = $(this).data('nohp');
                var email = $(this).data('email');
                var alamat = $(this).data('alamat');
                var keperluan = $(this).data('keperluan');
                var pendidikan = $(this).data('pendidikan'); // Tambahkan data pendidikan

                console.log($(this).data());

                // Set nilai input field berdasarkan data yang diambil
                $('#id_user').val(id_user);
                $('#nama').val(nama);
                $('#no_hp').val(nohp);
                $('#email').val(email);
                $('#alamat').val(alamat);

                // Set nilai untuk select pendidikan
                $('#pendidikan').val(pendidikan);

                // Set nilai untuk select keperluan
                $('#keperluan').val(keperluan);

                // Tampilkan modal edit
                $('#editModal').modal('show');
            });



            // Menangani form submit untuk mengupdate data
            $('#formTamu').on('submit', function(e) {
                e.preventDefault(); // Menghentikan pengiriman default

                $.ajax({
                    url: "<?= site_url('dashboard/ubah_data_pengunjung') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil diupdate!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#editModal').modal('hide');
                            setTimeout(function() {
                                location.reload(); // Refresh halaman setelah sukses
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data gagal diupdate!',
                            });
                        }
                    }
                });
            });

            // Menangani event klik pada tombol delete
            $(document).on('click', '.delete-btn', function() {
                var id_user = $(this).data('id_user');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin menghapus data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= site_url('dashboard/hapus_data_pengunjung') ?>",
                            type: "POST",
                            data: {
                                id_user: id_user
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: 'Data berhasil dihapus!',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        location.reload(); // Refresh halaman setelah sukses
                                    }, 2000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Data gagal dihapus!',
                                    });
                                }
                            }
                        });
                    }
                });
            });

            // Menangani tombol toggle sidebar
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
                $('#navbar').toggleClass('active');
            });
        });
    </script>


</body>

</html>