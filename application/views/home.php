<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nomor Antrian - Pengadilan Tata Usaha Negara Banjarmasin</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome for icons (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Custom styles -->
  <style>
    body {
      background-image: url('<?php echo base_url() ?>assets/images/latarptun.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      color: #000;
    }

    .header {
      color: black;
      padding: 10px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background: rgba(255, 255, 255, 0.2);
      /* Warna semi-transparan */
      backdrop-filter: blur(10px);
      /* Efek blur */
      -webkit-backdrop-filter: blur(10px);
      /* Untuk browser yang mendukung prefiks -webkit */
      border-radius: 10px;
      /* Opsional, membuat sudut melengkung seperti card */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* Opsional, bayangan agar terlihat seperti card */
      margin: 20px;
      /* Opsional, memberi jarak dari sisi halaman */
    }


    .header img {
      height: auto;
      max-height: 80px;
      margin-right: 20px;
    }

    .header h1 {
      margin-bottom: 0;
      font-size: 1.5rem;
      line-height: 1.2;
    }

    .datetime-text {
      font-size: 24px;
      font-weight: bold;
    }

    .footer {
      background-color: #343a40;
      color: #fff;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    .vidio-card {
      border: none;
      margin-bottom: 20px;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    .vidio-card .card-header {
      font-size: 20px;
      font-weight: bold;
    }

    .vidio-card .card-body {
      padding: 0;
      position: relative;
    }

    .vidio-card .card-body iframe {
      width: 100%;
      height: 250px;
    }

    .fullscreen-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 9999;
      background: rgba(0, 0, 0, 0.5);
      /* Latar belakang hitam dengan transparansi 50% */
      color: #fff;
      /* Warna teks putih */
      border: none;
      /* Menghilangkan border default */
      padding: 10px 15px;
      /* Padding untuk menambah ukuran klik area */
      border-radius: 5px;
      /* Membuat sudut tombol melengkung */
      cursor: pointer;
      /* Menambahkan kursor pointer untuk interaktif */
      transition: background 0.3s ease;
      /* Transisi halus saat hover */
    }

    .fullscreen-btn:hover {
      background: rgba(0, 0, 0, 0.7);
      /* Latar belakang lebih pekat saat hover */
    }


    .loket-card {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 200px;
      width: 200px;
    }

    .loket-card .card-header {
      flex: 1;
    }

    .loket-card .card-body {
      flex: 2;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <div class="container d-flex flex-column align-items-center">
      <div class="d-flex align-items-center justify-content-center">
        <img src="<?php echo base_url() ?>assets/images/ptun.jpg" alt="Logo PTUN">
        <img src="<?php echo base_url() ?>assets/images/stmik.jpg" alt="Logo STMIK Banjarbaru" class="ml-3">
      </div>
      <div class="text-center mt-3">
        <h1>DAFTAR ANTRIAN</h1>
        <h1>PENGADILAN TATA USAHA NEGARA BANJARMASIN</h1>
        <p id="datetime" class="mb-0 datetime-text"></p>
      </div>
    </div>
  </div>


  <!-- Isi -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <!-- Card Pelayanan -->
      <div class="col-md-10 w-100">
        <div class="card text-center vidio-card">
          <div class="card-header bg-primary text-white">
            Pelayanan
          </div>
          <div class="card-body">
            <div id="video-container">
              <iframe id="video" src="https://www.youtube.com/embed/fFUp1N0tcMk?autoplay=1&loop=1&playlist=fFUp1N0tcMk" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Row untuk Loket 1 - 5 -->
    <div class="row justify-content-center padding mt-4">
      <!-- Loket 1 -->
      <div class="col-md-2 mx-3">
        <div class="card text-center loket-card">
          <div class="card-header bg-primary text-white">
            Loket 1 - Kasir
          </div>
          <div class="card-body">
            <h1 id="loket1-number"><?php echo sprintf('%03d', $loket_kasir); ?>-K</h1>
          </div>
        </div>
      </div>
      <!-- Loket 2 -->
      <div class="col-md-2 mx-3">
        <div class="card text-center loket-card">
          <div class="card-header bg-success text-white">
            Loket 2 - Perkara
          </div>
          <div class="card-body">
            <h1 id="loket2-number"><?php echo sprintf('%03d', $loket_perkara); ?>-P</h1>
          </div>
        </div>
      </div>
      <!-- Loket 3 -->
      <div class="col-md-2 mx-3">
        <div class="card text-center loket-card">
          <div class="card-header bg-warning text-white">
            Loket 3 - Hukum
          </div>
          <div class="card-body">
            <h1 id="loket3-number"><?php echo sprintf('%03d', $loket_hukum); ?>-H</h1>
          </div>
        </div>
      </div>
      <!-- Loket 4 -->
      <div class="col-md-2 mx-3">
        <div class="card text-center loket-card">
          <div class="card-header bg-danger text-white">
            Loket 4 - Umum
          </div>
          <div class="card-body">
            <h1 id="loket4-number"><?php echo sprintf('%03d', $loket_umum); ?>-U</h1>
          </div>
        </div>
      </div>
      <!-- Loket 5 -->
      <div class="col-md-2 mx-3">
        <div class="card text-center loket-card">
          <div class="card-header bg-info text-white">
            Loket 5 - E-Court
          </div>
          <div class="card-body">
            <h1 id="loket5-number"><?php echo sprintf('%03d', $loket_ecourt); ?>-E</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tombol Fullscreen -->
  <button id="fullscreen-btn" class="fullscreen-btn btn btn-success" onclick="toggleFullScreen()">Fullscreen</button>

  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <p>Hak Cipta © 2024 Muhammad Hidayat-310123023780 STMIK BANJARBARU. All rights reserved.</p>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- Moment.js untuk format waktu -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script>
  <!-- Custom Script -->
  <script>
    $(document).ready(function() {
      // Konstanta nama hari dalam Bahasa Indonesia
      const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

      // Konstanta nama bulan dalam Bahasa Indonesia
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

      // Mengupdate waktu setiap detik
      function updateTime() {
        const now = moment();
        const formattedTime = now.format('dddd, D MMMM YYYY, HH:mm:ss');
        const dayName = days[now.day()];
        const monthName = months[now.month()];
        const timeString = `${dayName}, ${now.date()} ${monthName} ${now.year()}, ${now.format('HH:mm:ss')}`;
        $('#datetime').text(timeString);
      }
      setInterval(updateTime, 1000);

      // Fungsi untuk toggle fullscreen
      function toggleFullScreen() {
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { // Firefox
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
          document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
          document.documentElement.msRequestFullscreen();
        }
      }

      // Fullscreen button click event
      $('#fullscreen-btn').click(toggleFullScreen);

      setInterval(function() {
        $.ajax({
          url: '<?php echo base_url("home/get_antrian_data"); ?>', // URL endpoint untuk mendapatkan data terbaru
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            // Format nomor antrian menjadi 3 digit
            function formatNumber(num) {
              return num.toString().padStart(3, '0');
            }

            // Perbarui nomor antrian untuk setiap loket dengan format 3 digit
            $('#loket1-number').text(formatNumber(response.loket_kasir) + '-K');
            $('#loket2-number').text(formatNumber(response.loket_perkara) + '-P');
            $('#loket3-number').text(formatNumber(response.loket_hukum) + '-H');
            $('#loket4-number').text(formatNumber(response.loket_umum) + '-U');
            $('#loket5-number').text(formatNumber(response.loket_ecourt) + '-E');
          },
          error: function() {
            console.error('Error in fetching data.');
          }
        });
      }, 5000);

    });
  </script>
</body>

</html>