<?php
  echo $t['deskripsi'] . '<br>';echo "<strong>Daftar Tugas:</strong><br>";
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
echo "<br>";
