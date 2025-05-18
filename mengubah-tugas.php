<?php
$tugas = [
    'id' => 1,
    'deskripsi' => 'Hiking Gunung Batur',
    'waktu' => 50
];

$sql = 'UPDATE tugas SET deskripsi = :deskripsi, waktu = :waktu WHERE id = :id';
$statement = $conn->prepare($sql);
$statement->bindParam(':id', $tugas['id'], PDO::PARAM_INT);
$statement->bindParam(':deskripsi', $tugas['deskripsi']);
$statement->bindParam(':waktu', $tugas['waktu'], PDO::PARAM_INT);

if ($statement->execute()) {
    echo "Tugas dengan ID {$tugas['id']} berhasil diupdate!<br><br>";
} else {
    echo "Gagal mengupdate tugas.<br><br>";
}
?>
