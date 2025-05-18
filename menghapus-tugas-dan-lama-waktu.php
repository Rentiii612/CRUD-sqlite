<?php $id = 1;
$sql = 'DELETE FROM tugas WHERE id = :id';
$statement = $conn->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
if ($statement->execute()) {
    echo "Tugas dengan ID $id berhasil dihapus!<br><br>";
} else {
    echo "Gagal menghapus tugas dengan ID $id.<br><br>";
}
?>
