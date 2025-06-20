<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Nama</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
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
    <h2>Data Nama</h2>
    <button id="refreshButton">Refresh</button>
    <img id="loading" src="https://i.gifer.com/ZZ5H.gif" alt="loading" width="25">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody id="dataBody">
            <?php $no = 1; ?>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row->nama; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#refreshButton').click(function() {
                $('#loading').show(); // Menampilkan animasi loading
                $.ajax({
                    url: '<?php echo base_url('index.php/contoh/get_anggota'); ?>',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#loading').hide(); // Menyembunyikan animasi loading
                        var dataBody = $('#dataBody');
                        dataBody.empty(); // Mengosongkan tabel sebelum memuat data baru
                        
                        var no = 1;
                        data.forEach(function(row) {
                            var tr = `<tr>
                                <td>${no++}</td>
                                <td>${row.nama}</td>
                            </tr>`;
                            dataBody.append(tr);
                        });
                    },
                    error: function(xhr, status, error) {
                        $('#loading').hide(); // Menyembunyikan animasi loading
                        console.error('Terjadi kesalahan saat memuat data:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
