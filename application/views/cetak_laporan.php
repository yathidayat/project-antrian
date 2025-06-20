<?php
function getNamaBulan($bulan)
{
    // Array bulan dalam bahasa Indonesia
    $nama_bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    // Mengembalikan nama bulan sesuai angka yang diberikan
    return $nama_bulan[(int)$bulan];
}


function getNamaHari($tanggal)
{
    // Mengambil nama hari berdasarkan tanggal
    $hari = date('N', strtotime($tanggal));
    $nama_hari = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    ];

    return $nama_hari[$hari];
}

function formatTanggalLengkap($tanggal)
{
    // Format menjadi "Hari, tanggal/bulan/tahun"
    $hari = getNamaHari($tanggal);
    $tanggal_format = date('d/m/Y', strtotime($tanggal));
    return "$hari, $tanggal_format";
}

// Semua kategori pendidikan
$pendidikan_kategori = ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2'];
$pendidikan_data = [];
foreach ($pendidikan_kategori as $kategori) {
    $pendidikan_data[$kategori] = 0; // Inisialisasi dengan 0
}

// Populate data pendidikan dari database
foreach ($pendidikan as $pend) {
    $pendidikan_data[$pend['pendidikan']] = (int)$pend['total'];
}

// Semua kategori jenis kelamin
$jenis_kelamin_kategori = ['Laki-laki', 'Perempuan'];
$jenis_kelamin_data = [];
foreach ($jenis_kelamin_kategori as $jk) {
    $jenis_kelamin_data[$jk] = 0; // Inisialisasi dengan 0
}

// Populate data jenis kelamin dari database
foreach ($jenis_kelamin as $jk) {
    $jenis_kelamin_data[$jk['jenis_kelamin']] = (int)$jk['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengunjung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            font-size: 1rem;
        }

        h3 {
            text-align: center;
            font-size: 0.9rem;
        }

        .cop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .cop-surat img {
            width: 100px;
            /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
            /* Menjaga proporsi logo */
            margin-right: 20px;
            /* Spasi antara logo dan teks */
        }

        .cop-surat div {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="cop-surat">
        <img src="<?php echo base_url() ?>assets/images/ptun.jpg" alt="Logo PTUN">
        <div>
            MAHKAMAH AGUNG REPUBLIK INDONESIA<br>
            DIREKTORAT JENDERAL BADAN PERADILAN MILITER DAN PERADILAN TATA USAHA NEGARA<br>
            PENGADILAN TINGGI TATA USAHA NEGARA BANJARMASIN<br>
            PENGADILAN TATA USAHA NEGARA BANJARMASIN<br>
            Jalan Brigjend H. Hasan Basri No. 32 Kayutangi Banjarmasin 70123<br>
            www.ptun-banjarmasin.go.id, surel@ptun-banjarmasin.go.id
        </div>
    </div>

    <hr class="padding-top" style="font-weight: bold; margin-top: 20px; border-width: 2px;">

    <table style="border: none; border-collapse: collapse; padding: 0; margin: 0;">
        <tr style="border: none;">
            <th style="border: none; text-align: left; padding: 0; margin: 0;">Nama</th>
            <td style="border: none; padding: 0 5px; margin: 0;">:</td>
            <td style="border: none; padding: 0; margin: 0;"><?= $username ?></td>
        </tr>
        <tr style="border: none;">
            <th style="border: none; text-align: left; padding: 0; margin: 0;">Posisi</th>
            <td style="border: none; padding: 0 5px; margin: 0;">:</td>
            <td style="border: none; padding: 0; margin: 0;">Resepsionis</td>
        </tr>
        <tr style="border: none;">
            <th style="border: none; text-align: left; padding: 0; margin: 0;">Tanggal</th>
            <td style="border: none; padding: 0 5px; margin: 0;">:</td>
            <td style="border: none; padding: 0; margin: 0;">
                <?php
                $tanggal_sekarang = date('Y-m-d'); // Tanggal cetak saat ini dalam format Y-m-d
                $hari = getNamaHari($tanggal_sekarang); // Mendapatkan nama hari
                $tanggal = date('d'); // Mendapatkan tanggal
                $bulanSekarang = date('m'); // Mendapatkan bulan
                $tahunSekarang = date('Y'); // Mendapatkan tahun

                echo $hari . ', ' . $tanggal . ' ' . getNamaBulan($bulanSekarang) . ' ' . $tahunSekarang;
                ?>
            </td>
        </tr>

    </table>


    <hr class="padding-top" style="font-weight: bold; margin-top: 20px; border-width: 2px;">


    <!-- Tabel Data Pengunjung -->
    <h3>Laporan Data Pengunjung Pengadilan Tata Usaha Negara Banjarmasin <?php echo getNamaBulan($bulan); ?> Tahun <?php echo $tahun; ?></h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Nomor WhatsApp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Pendidikan</th>
                <th>Keperluan</th>
                <th>Waktu</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataPengunjung as $pengunjung): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['nama']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['nohp']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['email']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['pendidikan']); ?></td>
                    <td><?php echo htmlspecialchars($pengunjung['keperluan']); ?></td>
                    <td><?php echo formatTanggalLengkap($pengunjung['waktu']); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr class="padding-top" style="font-weight: bold; margin-top: 20px; border-width: 2px;">


    <h2>Rekapitulasi Data Pengunjung Pengadilan Tata Usaha Negara Banjarmasin</h2>
    <h3>Rekapitulasi Antrian Bulan <?php echo getNamaBulan($bulan); ?> Tahun <?php echo $tahun; ?></h3>

    <!-- Tabel Loket dan Jumlah Antrian -->
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Loket</th>
                <th>Jumlah Antrian</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Daftar kode loket yang ingin ditampilkan
            $loket = ['K' => 'Kasir', 'H' => 'Hukum', 'P' => 'Perkara', 'U' => 'Umum', 'E' => 'E-Court'];

            $no = 1; // Inisialisasi nomor urut
            foreach ($loket as $kode => $nama_loket):
                // Cek apakah ada data untuk kode loket ini
                $jumlah_antrian = 0;
                foreach ($laporan as $row) {
                    if ($row['kode_loket'] == $kode) {
                        $jumlah_antrian = $row['jumlah_antrian'];
                        break;
                    }
                }
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nama_loket; ?></td>
                    <td><?php echo $jumlah_antrian; ?></td>
                    <td><!-- Keterangan sesuai kebutuhan --></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



    <!-- Tabel untuk Total Pengunjung -->
    <h3>Rekapitulasi Pengunjung Bulan <?php echo getNamaBulan($bulan); ?> Tahun <?php echo $tahun; ?></h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Bulan</th>
                <th>Total Pengunjung</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><?php echo getNamaBulan($bulan); ?></td>
                <td><?php echo $total_pengunjung; ?></td>
                <td><!-- Keterangan sesuai kebutuhan --></td>
            </tr>
        </tbody>
    </table>


    <!-- Tabel untuk Pendidikan -->
    <h3>Rekapitulasi Pengunjung Berdasarkan Pendidikan</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Pendidikan</th>
                <th>Total</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; // Inisialisasi nomor urut
            foreach ($pendidikan_kategori as $kategori): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $kategori; ?></td>
                    <td><?php echo $pendidikan_data[$kategori]; ?></td>
                    <td><!-- Keterangan sesuai kebutuhan --></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabel untuk Jenis Kelamin -->
    <h3>Rekapitulasi Pengunjung Berdasarkan Jenis Kelamin</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Kelamin</th>
                <th>Total</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; // Inisialisasi nomor urut
            foreach ($jenis_kelamin_kategori as $jk): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $jk; ?></td>
                    <td><?php echo $jenis_kelamin_data[$jk]; ?></td>
                    <td><!-- Keterangan sesuai kebutuhan --></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 30px;">
        <tr style="border: none;">
            <td style="border: none; text-align: left; padding-left: 50px;">
                <p>Tanda Tangan Petugas,</p>
                <br><br>
                <p>...................................</p>
                <p><?= $username ?></p>
            </td>
        </tr>
    </table>


    <script>
        window.onload = function() {
            window.print(); // Cetak laporan saat halaman selesai dimuat
        };
    </script>
</body>


</html>