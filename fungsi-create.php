<?php
// Koneksi ke database SQLite
try {
    $conn = new PDO("sqlite:database.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
$deskripsi = 'Tidur siang';
$waktu = 90;
$sql = 'INSERT INTO tugas(deskripsi, waktu) VALUES(:deskripsi, :waktu)';
$statement = $conn->prepare($sql);
$statement->execute([
    ':deskripsi' => $deskripsi,
    ':waktu' => $waktu
]);
$tugas_id = $conn->lastInsertId();
echo "Tugas baru berhasil ditambahkan dengan ID: $tugas_id<br><br>";
