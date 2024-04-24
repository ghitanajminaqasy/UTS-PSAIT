<?php

if(isset($_POST['submit']))
{    
    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];
    $nilai = $_POST['nilai'];

    // Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
    $url = 'http://localhost/sait_uts_api/sait_api.php';
    
    // Data yang akan dikirim ke REST API, dengan format JSON
    $jsonData = array(
        'nim' =>  $nim,
        'kode_mk' =>  $kode_mk,
        'nilai' => $nilai,
    );

    // Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);
    
    // Inisialisasi cURL session
    $ch = curl_init($url);
    
    // Set options untuk cURL session
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    // Eksekusi request
    $result = curl_exec($ch);
    $result = json_decode($result, true);

    // Tutup session cURL
    curl_close($ch);

    // Tampilkan pesan hasil pembaruan data
    if ($result !== null && isset($result["status"]) && isset($result["message"])) {
        echo "<center><br>Status : {$result["status"]} "; 
        echo "<br>Message : {$result["message"]} "; 
        echo "<br>Sukses mengupdate data di server Ubuntu!";
    } else {
        echo "Failed to update data.";
    }

    // Tautan untuk kembali ke halaman selectNilaiView.php
    echo "<br><a href='selectNilaiView.php'>OK</a>";
}
?>
