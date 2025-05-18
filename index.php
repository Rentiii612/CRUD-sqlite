<?php
// Koneksi ke database SQLite
$conn = new PDO("sqlite:database.db");

// Inisialisasi pesan
$pesan = "";

// Tambah tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $deskripsi = $_POST['deskripsi'];
    $waktu = $_POST['waktu'];

    $sql = 'INSERT INTO tugas(deskripsi, waktu) VALUES(:deskripsi, :waktu)';
    $statement = $conn->prepare($sql);
    $statement->execute([
        ':deskripsi' => $deskripsi,
        ':waktu' => $waktu
    ]);

    $id_baru = $conn->lastInsertId();
    $pesan = "Tugas dengan ID $id_baru berhasil ditambahkan!";
}

// Hapus tugas
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = 'DELETE FROM tugas WHERE id = :id';
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    if ($statement->execute()) {
        $pesan = "Tugas dengan ID $id telah dihapus!";
    } else {
        $pesan = "Gagal menghapus tugas dengan ID $id.";
    }
}

// Ambil semua data tugas
$sql = 'SELECT * FROM tugas ORDER BY id DESC';
$statement = $conn->query($sql);
$tugas = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Tugas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
            color: #333;
        }

        h1 {
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        .pesan {
            background-color: #e0f7e9;
            border: 1px solid #a5d6a7;
            padding: 12px;
            margin-bottom: 20px;
            color: #2e7d32;
            border-radius: 6px;
        }

        .tugas {
            background-color: #ffffff;
            padding: 12px 16px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        form {
            background-color: #ffffff;
            padding: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 30px;
        }

        input[type="text"], input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #2e86de;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1b4f72;
        }

        .hapus {
            color: red;
            text-decoration: none;
            font-size: 0.9em;
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Manajemen Tugas</h1>

    <?php if ($pesan): ?>
        <div class="pesan"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <?php foreach ($tugas as $t): ?>
        <div class="tugas">
            <strong><?= $t['id'] ?>.</strong> <?= htmlspecialchars($t['deskripsi']) ?> (<?= $t['waktu'] ?> menit)
            <a class="hapus" href="?hapus=<?= $t['id'] ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
        </div>
    <?php endforeach; ?>

    <form method="POST">
        <h3>Tambah Tugas Baru</h3>
        <input type="text" name="deskripsi" placeholder="Deskripsi tugas" required>
        <input type="number" name="waktu" placeholder="Durasi (menit)" required>
        <button type="submit" name="tambah">Tambah</button>
    </form>
</div>
</body>
</html>

