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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            margin-top: auto;
            /* agar footer tetap di bawah konten */
        }

        .footer p {
            margin: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            padding-bottom: 60px;
            /* Spasi tambahan agar konten tidak tertutup */
            transition: margin-left 0.3s;
            flex-grow: 1;
            /* Biar mengisi ruang sisa di antara sidebar dan footer */
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

        .datetime-text {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    

    <div class="sidebar" id="sidebar">
        <a href="<?= site_url('dashboard/admin') ?>"><span>Monitoring</span></a>
        <a href="<?= site_url('dashboard/pelayanan') ?>"><span>Pelayanan</span></a>

        <!-- Menu dengan dropdown untuk Data Master -->
        <a href="#dataMasterSubmenu" data-bs-toggle="collapse" class="dropdown-toggle"><span>Data Master</span></a>
        <ul class="collapse list-unstyled" id="dataMasterSubmenu">
            <li><a href="<?= site_url('dashboard/pengguna') ?>"><span>Data Pengguna</span></a></li>
            <li><a href="<?= site_url('dashboard/pengunjung') ?>"><span>Data Pengunjung</span></a></li>
            <li><a href="<?= site_url('dashboard/laporan') ?>"><span>Data Laporan</span></a></li>
        </ul>

        <!-- Tombol Logout di bagian bawah -->
        <a href="<?= site_url('auth/logout') ?>" class="logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <p id="datetime" class="mb-0 datetime-text"></p>
        </div>
    </nav>

    <div class="content" id="content">
        <div class="container">
            <div class="form-container">
                <h2 class="text-center my-4">Form Tamu</h2>
                <form id="formTamu" class="container">
                    <!-- Row 1: Nama dan Nomor Whatsapp -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">Nomor Whatsapp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh: 0852xxx">
                        </div>
                    </div>

                    <!-- Row 2: Umur dan Pendidikan -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" class="form-control" id="umur" name="umur" placeholder="Umur anda saat ini?" min="1">
                        </div>
                        <div class="col-md-6">
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
                    </div>

                    <!-- Row 3: Email dan Jenis Kelamin -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: emailanda@gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="laki-laki" name="jenis_kelamin" value="Laki-laki">
                                <label for="laki-laki" class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="perempuan" name="jenis_kelamin" value="Perempuan">
                                <label for="perempuan" class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Alamat dan Keperluan -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat" required></textarea>
                        </div>
                        <div class="col-md-6">
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
                    </div>

                    <!-- Row 5: Foto -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div id="camera-container">
                                <video id="video" width="300" height="200" autoplay></video>
                                <canvas id="canvas" width="300" height="200" style="display:none;"></canvas>
                                <button id="snap" type="button" class="btn btn-danger mt-2">Ambil Foto</button>
                                <button id="retake" type="button" class="btn btn-secondary mt-2" style="display:none;">Ulangi Foto</button>
                            </div>

                            <!-- Hidden input to store image data -->
                            <input type="hidden" id="imageData" name="imageData">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal HTML -->
    <div class="modal fade" id="pelayananModal" tabindex="-1" aria-labelledby="pelayananModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pelayananModalLabel">Pelayanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script>

    <script>
        // Access the video and canvas elements
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snapButton = document.getElementById('snap');
        const retakeButton = document.getElementById('retake');
        const imageDataInput = document.getElementById('imageData');
        const context = canvas.getContext('2d');

        $(document).ready(function() {

            // Konstanta nama hari dalam Bahasa Indonesia
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

            // Konstanta nama bulan dalam Bahasa Indonesia
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            // Ajax form submit
            $('#formTamu').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: '<?= site_url('dashboard/simpan_buku_tamu') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan. Apakah Anda ingin mencetak nomor antrian?',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Buka modal pelayanan
                                    $('#pelayananModal').modal('show');
                                } else {
                                    Swal.fire('Pencetakan dibatalkan', '', 'info');
                                    // Reload halaman setelah klik "Tidak"
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000); // Menunggu 2 detik sebelum reload
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan, coba lagi!',
                            icon: 'error'
                        });
                    }
                });
            });

            function updateTime() {
                const now = moment();
                const formattedTime = now.format('dddd, D MMMM YYYY, HH:mm:ss');
                const dayName = days[now.day()];
                const monthName = months[now.month()];
                const timeString = `${dayName}, ${now.date()} ${monthName} ${now.year()}, ${now.format('HH:mm:ss')}`;
                $('#datetime').text(timeString);
            }
            setInterval(updateTime, 1000);
        });

        // Mapping kode loket ke nama loket
        const loketNames = {
            'H': 'Hukum',
            'P': 'Perkara',
            'U': 'Umum',
            'K': 'Kasir',
            'E': 'E-Court'
        };

        function cetakStruk(kodeLoket, nomorAntrian) {
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
                    const strukHtml = `
                <html>
                <head>
                    <style>
                        @media print {
                            @page { size: 58mm auto; margin: 0; }
                            body { margin: 0; padding: 0; font-family: sans-serif; }
                            .container { width: 47mm; padding: 0; text-align: center; }
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

                    // Setelah selesai mencetak, munculkan SweetAlert dan reload halaman
                    Swal.fire({
                        title: 'Selesai',
                        text: 'Struk telah dicetak.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Tutup modal dan reload halaman
                        $('#pelayananModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // Tunggu 1 detik sebelum reload
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mencetak struk!',
                        icon: 'error'
                    });
                });
        }

        // Access camera
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((err) => {
                console.error("Error accessing the camera", err);
            });

        // Capture photo
        snapButton.addEventListener('click', () => {
            // Draw the video frame on the canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert the canvas image to a base64 string
            const imageData = canvas.toDataURL('image/png');

            // Store image data in hidden input field
            imageDataInput.value = imageData;

            // Hide the video and snap button, show the canvas and retake button
            video.style.display = 'none';
            canvas.style.display = 'block';
            snapButton.style.display = 'none';
            retakeButton.style.display = 'inline-block';
        });

        // Retake photo
        retakeButton.addEventListener('click', () => {
            // Clear the canvas and reset the UI
            context.clearRect(0, 0, canvas.width, canvas.height);

            // Show the video and snap button again, hide the canvas and retake button
            video.style.display = 'block';
            canvas.style.display = 'none';
            snapButton.style.display = 'inline-block';
            retakeButton.style.display = 'none';
        });
    </script>

</body>


</html>