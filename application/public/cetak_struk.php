<?php
require __DIR__ . '/../vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode_loket'])) {
    $kode_loket = $_POST['kode_loket'];
    $nomor_antrian = rand(1, 100); // Ganti dengan logika pengambilan nomor antrian yang sesuai
    $struk = "PENGADILAN TATA USAHA NEGARA BANJARMASIN\n";
    $struk .= "Nomor Antrian: " . str_pad($nomor_antrian, 3, '0', STR_PAD_LEFT) . "\n";
    $struk .= "Loket: " . strtoupper($kode_loket) . "\n";
    $struk .= "Terima kasih atas kunjungan Anda\n";

    try {
        $connector = new WindowsPrintConnector("Receipt Printer"); // Ganti dengan nama share printer Anda
        $printer = new Printer($connector);
        $printer->text($struk);
        $printer->cut();
        $printer->close();
        echo "Cetak berhasil";
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
