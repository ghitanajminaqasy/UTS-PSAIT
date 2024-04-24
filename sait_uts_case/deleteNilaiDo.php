<?php

$nim = $_GET['nim'];
$kode_mk = $_GET['kode_mk'];
// Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
$url = 'http://localhost/sait_uts_api/sait_api.php?nim=' . $nim . '&kode_mk=' . $kode_mk;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// Pastikan metodenya adalah DELETE
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
// Periksa apakah respons dari server tidak null
if ($result !== false) {
    // Jika respons tidak null, dekodekan respons JSON
    $result = json_decode($result, true);

    // Cek apakah respons memiliki status dan pesan
    if (isset($result["status"]) && isset($result["message"])) {
        // Tampilkan status dan pesan
        echo "<center><br>Status: {$result["status"]}";
        echo "<br>Message: {$result["message"]}";

        // Jika berhasil, tampilkan pesan sukses
        if ($result["status"] === "success") {
            echo "<br>Sukses menghapus data di server Ubuntu!";
        }
    } else {
        // Jika respons tidak memiliki status atau pesan, tampilkan pesan kesalahan
        echo "<center><br>Terjadi kesalahan dalam respons dari server!";
    }
} else {
    // Jika respons null, tampilkan pesan kesalahan
    echo "<center><br>Terjadi kesalahan dalam komunikasi dengan server!";
}

// Menutup koneksi cURL
curl_close($ch);

// Tampilkan tautan untuk kembali ke halaman tampilan data
echo "<br><a href='selectNilaiView.php'>OK</a>";

?>
