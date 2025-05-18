<?php
// Koneksi ke database SQLite
try {
    $conn = new PDO("sqlite:database.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
echo "<h3>Daftar Semua Tugas</h3>";

$sql = 'SELECT id, deskripsi, waktu FROM tugas';
$statement = $conn->query($sql);
$tugas = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($tugas) {
    foreach ($tugas as $t) {
        echo $t['id'] . ". " . $t['deskripsi'] . " (" . $t['waktu'] . " menit)<br>";
    }
} else {
    echo "Belum ada tugas.<br>";
}

echo "<hr>";

$id = 1;

echo "<h3>Detail Tugas ID $id</h3>";

$sql = 'SELECT id, deskripsi, waktu FROM tugas WHERE id = :tugas_id';
$statement = $conn->prepare($sql);
$statement->bindParam(':tugas_id', $id, PDO::PARAM_INT);
$statement->execute();
$tugas = $statement->fetch(PDO::FETCH_ASSOC);

if ($tugas) {
    echo $tugas['id'] . ". " . $tugas['deskripsi'] . " (" . $tugas['waktu'] . " menit)<br>";
} else {
    echo "Tugas dengan ID $id tidak ditemukan.<br>";
}
?>

