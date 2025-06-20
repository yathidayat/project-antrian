<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Pengadilan Tata Usaha Banjarmasin</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Gaya kustom -->
  <style>
    body {
      background-color: #f8f9fa;
    }

    .header {
      background-color: #007bff;
      color: #fff;
      padding: 20px 0;
    }

    .footer {
      background-color: #343a40;
      color: #fff;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    .loket-card {
      border: none;
      margin-bottom: 20px;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    .loket-card .card-header {
      font-size: 18px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .loket-card .card-body {
      padding: 20px;
    }

    .loket-card .card-body h1 {
      font-size: 72px;
      margin-top: 10px;
      margin-bottom: 0;
    }

    .icon-link {
      position: relative;
      display: inline-block;
      transition: transform 0.3s;
    }

    .icon-link:hover {
      transform: scale(1.2);
    }

    .icon-link .tooltip-text {
      visibility: hidden;
      width: 100px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      bottom: 100%;
      left: 50%;
      margin-left: -50px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .icon-link:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }

    #refreshButton {
      float: right;
      margin-bottom: 10px;
      padding: 8px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    #refreshButton:hover {
      background-color: #0056b3;
    }

    #loading {
      display: none;
      float: right;
      margin-left: 10px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header text-center">
    <div class="container">
      <h1>LOKET 2 - PERKARA</h1>
      <p>PENGADILAN TATA USAHA NEGARA BANJARMASIN</p>
    </div>
  </div>

  <!-- Menu -->
  <div class="container mt-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Dashboard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Antrian Loket</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <!-- Isi -->
  <div class="container mt-4">
    <div class="row justify-content-center">
      <!-- Loket 3 -->
      <div class="col-md-12">
        <div class="card loket-card">
          <div class="card-header bg-primary text-white">
            <span>Daftar Antrian Loket 2</span>
            <button id="refreshButton" class="btn btn-light btn-sm" onclick="location.reload();">
              <i class="fas fa-sync-alt"></i>
            </button>
            <img id="loading" src="https://i.gifer.com/ZZ5H.gif" alt="loading" width="25">
          </div>
          <div class="card-body">
            <table class="table table-striped" id="antrianTable">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nomor Antrian</th>
                  <th scope="col">Aksi</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody id="dataBody">
                <?php foreach ($antrian as $row) : ?>
                  <?php if ($row->status !== 'selesai') : ?>
                    <tr id="antrian_<?php echo $row->id; ?>">
                      <td><?php echo $row->nomor; ?></td>
                      <td><strong><?php echo sprintf('%03d-%s', $row->nomor, $row->kode_loket); ?></strong></td>
                      <td>
                        <a href="#" class="icon-link" onclick="updateAntrian(<?php echo $row->nomor; ?>, '<?php echo $row->kode_loket; ?>', 'panggil')" <?php echo $row->status !== 'menunggu' ? 'disabled' : ''; ?>>
                          <span class="tooltip-text">Panggil</span>
                          <i class="fas fa-play mr-2"></i>
                        </a>
                        <a href="#" class="icon-link" onclick="updateAntrian(<?php echo $row->nomor; ?>, '<?php echo $row->kode_loket; ?>', 'selesai')" <?php echo $row->status !== 'dipanggil' ? 'disabled' : ''; ?>>
                          <span class="tooltip-text">Selesai</span>
                          <i class="fas fa-flag mr-2"></i>
                        </a>
                        <!-- <a href="#" class="icon-link" onclick="playSound(<?php echo $row->nomor; ?> , '<?php echo $row->kode_loket; ?>')">
                          <span class="tooltip-text">Suara</span>
                          <i class="fas fa-volume-up"></i>
                          
                        </a> -->
                      </td>
                      <td style="color: <?php echo ($row->status == 'menunggu') ? 'red' : (($row->status == 'dipanggil') ? 'orange' : 'green'); ?>;">
                        <strong>
                          <?php
                          if ($row->status == 'menunggu') {
                            echo 'Menunggu';
                          } elseif ($row->status == 'dipanggil') {
                            echo 'Dipanggil';
                          } else {
                            echo 'Selesai';
                          }
                          ?>
                        </strong>
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div id="noDataMessage" class="text-center text-muted" style="display: none;">
              Tidak ada data tersedia
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-deck">
      <?php foreach ($loket as $l): ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Loket <?= $l->id ?> - <?= $l->nama_loket ?></h5>
            <p class="card-text"><?= str_pad($l->nomor_terakhir, 3, '0', STR_PAD_LEFT) ?>-<?= strtoupper($l->kode_loket) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <p>Hak Cipta © 2024 Muhammad Hidayat-310123023780 STMIK BANJARBARU. All rights reserved.</p>

    
    </div>
    <div style="position: fixed; bottom: 10px; left: 10px;">
      <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </footer>

  <audio id="audioElement" src="<?php echo base_url() ?>assets\sound\call-to-attention-123107.mp3"></audio>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // function playSound(nomorAntrian) {
    //   var utterance = new SpeechSynthesisUtterance('Nomor antrian ' + ('000' + nomorAntrian).slice(-3) + ' untuk loket ' + 'PERKARA' + '. Silakan menuju loket.');
    //   utterance.lang = 'id-ID'; // Set bahasa ke Bahasa Indonesia
    //   window.speechSynthesis.speak(utterance);
    // }

    function numberToWords(num) {
      const ones = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
      const tens = ["", "", "dua puluh", "tiga puluh", "empat puluh", "lima puluh", "enam puluh", "tujuh puluh", "delapan puluh", "sembilan puluh"];
      let word = '';

      if (num < 12) {
        word = ones[num];
      } else if (num < 20) {
        word = ones[num - 10] + ' belas';
      } else if (num < 100) {
        word = tens[Math.floor(num / 10)] + (num % 10 > 0 ? ' ' + ones[num % 10] : '');
      } else if (num < 200) {
        word = "seratus" + (num % 100 > 0 ? ' ' + numberToWords(num % 100) : '');
      } else if (num < 1000) {
        word = ones[Math.floor(num / 100)] + " ratus" + (num % 100 > 0 ? ' ' + numberToWords(num % 100) : '');
      } else if (num < 2000) {
        word = "seribu" + (num % 1000 > 0 ? ' ' + numberToWords(num % 1000) : '');
      } else {
        word = "nomor terlalu besar";
      }

      return word;
    }

    function playSound(nomor, kode_loket) {
      var audio = document.getElementById('audioElement');
      audio.play();
      audio.onended = function() {
        var message = new SpeechSynthesisUtterance("Nomor antrian " + numberToWords(nomor) + ' ' + kode_loket + ' .Silakan menuju loket.' + 'PERKARA');
        message.lang = 'id-ID';
        window.speechSynthesis.speak(message);
      };
    }


    function updateAntrian(id, action) {
      $('#loading').show();

      $.ajax({
        url: '<?php echo base_url('antrian/update_antrian/P'); ?>',
        type: 'POST',
        data: {
          id: id,
          action: action
        },
        success: function(response) {
          $('#loading').hide();
          response = JSON.parse(response);
          if (response.success) {
            refreshAntrianData();
          } else {
            Swal.fire(response.message).then(() => {
              refreshAntrianData();
            });
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
          $('#loading').hide();
        }
      });
    }

    function refreshAntrianData() {
      $('#loading').show();

      $.ajax({
        url: '<?php echo base_url('dashboard/get_antrian_loket/P'); ?>',
        type: 'GET',
        success: function(data) {
          $('#loading').hide();
          $('#dataBody').empty();

          var antrian = JSON.parse(data);
          if (antrian.length > 0) {
            $('#noDataMessage').hide();
            antrian.forEach(function(row) {
              if (row.status !== 'selesai') {
                var statusColor = (row.status === 'menunggu') ? 'red' : ((row.status === 'dipanggil') ? 'orange' : 'green');
                var statusText = (row.status === 'menunggu') ? 'Menunggu' : ((row.status === 'dipanggil') ? 'Dipanggil' : 'Selesai');

                $('#dataBody').append(
                  '<tr id="antrian_' + row.id + '">' +
                  '<td>' + row.nomor + '</td>' +
                  '<td><strong>' + ('000' + row.nomor).slice(-3) + '-' + row.kode_loket + '</strong></td>' +
                  '<td>' +
                  '<a href="#" class="icon-link" onclick="updateAntrian(' + row.id + ', \'panggil\')" ' + (row.status !== 'menunggu' ? 'disabled' : '') + '>' +
                  '<span class="tooltip-text">Panggil</span>' +
                  '<i class="fas fa-play mr-2"></i>' +
                  '</a>' +
                  '<a href="#" class="icon-link" onclick="updateAntrian(' + row.id + ', \'selesai\')" ' + (row.status !== 'dipanggil' ? 'disabled' : '') + '>' +
                  '<span class="tooltip-text">Selesai</span>' +
                  '<i class="fas fa-flag mr-2"></i>' +
                  '</a>' +
                  // '<a href="#" class="icon-link" onclick="playSound(' + row.nomor + ', \'' + row.kode_loket + '\')">' +
                  // '<span class="tooltip-text">Suara</span>' +
                  // '<i class="fas fa-volume-up"></i>' +
                  // '</a>' +
                  '</td>' +
                  '<td style="color: ' + statusColor + ';"><strong>' + statusText + '</strong></td>' +
                  '</tr>'
                );
              }
            });
          } else {
            $('#noDataMessage').show();
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
          $('#loading').hide();
        }
      });
    }

    $(document).ready(function() {
      refreshAntrianData();
      setInterval(refreshAntrianData, 3000);
    });
  </script>
  <!-- Bootstrap JS dan Popper.js -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>