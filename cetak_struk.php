<?php
// Ambil data dari request POST
$kode_loket = $_POST['kode_loket'] ?? '';

// Template cetakan
$header = "PENGADILAN TATA USAHA NEGARA BANJARMASIN\n";
$footer = "\nTerima kasih atas kunjungan Anda";

// Ambil nomor antrian dari database atau sumber lain sesuai kebutuhan Anda
// Misalnya, nomor antrian dummy untuk contoh ini
$nomorAntrian = "123";

// Format struk
$struk = "{$header}Nomor Antrian: {$nomorAntrian}\nLoket: {$kode_loket}\n{$footer}";

// Path ke printer (ganti dengan path printer Anda)
$printerPath = "LPT1"; // Ganti dengan port atau path printer Anda

// Cetak struk
try {
    // Menulis ke printer
    $handle = fopen($printerPath, 'w');
    if ($handle === false) {
        throw new Exception("Gagal membuka printer.");
    }
    fwrite($handle, $struk);
    fclose($handle);
    echo "Struk berhasil dicetak.";
} catch (Exception $e) {
    echo "Gagal mencetak: " . $e->getMessage();
}
?>
