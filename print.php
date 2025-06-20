<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kodeLoket = $_POST['kode_loket'];
    $nomorAntrian = $_POST['nomor_antrian'];

    // Template cetakan
    $header = "PENGADILAN TATA USAHA NEGARA BANJARMASIN\n";
    $footer = "\nTerima kasih atas kunjungan Anda";
    $struk = "$header\nNomor Antrian: $nomorAntrian\nLoket: $kodeLoket\n$footer";

    // Path printer thermal Anda
    $printerPath = "LPT1"; // Ganti dengan path printer Anda, bisa LPT1, COM1, atau USB

    // Menulis data ke printer
    $handle = fopen($printerPath, "w");
    if ($handle) {
        fwrite($handle, $struk);
        fclose($handle);
        echo "Cetak berhasil";
    } else {
        echo "Gagal terhubung ke printer";
    }
} else {
    echo "Metode HTTP tidak valid";
}
?>
