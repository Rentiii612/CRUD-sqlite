<?php
// Koneksi ke SQLite
try {
    $conn = new PDO("sqlite:database.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Tambah data jika ada form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tambah'])) {
    $deskripsi = $_POST['deskripsi'];
    $waktu = (int) $_POST['waktu'];

    $sql = 'INSERT INTO tugas(deskripsi, waktu) VALUES(:deskripsi, :waktu)';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':deskripsi' => $deskripsi,
        ':waktu' => $waktu
    ]);
    header("Location: index.php");
    exit;
}

// Hapus tugas
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $sql = 'DELETE FROM tugas WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Tampilkan semua tugas
$sql = 'SELECT * FROM tugas ORDER BY id DESC';
$statement = $conn->query($sql);
$tugas = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f8fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            background-color: #7FB3D5;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5499C7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 8px;
            text-align: left;
        }

        th {
            background-color: #AED6F1;
            color: #2C3E50;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .actions a {
            margin-right: 10px;
            color: #2980B9;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Manajemen Tugas</h1>

    <form method="POST">
        <input type="text" name="deskripsi" placeholder="Deskripsi tugas" required>
        <input type="number" name="waktu" placeholder="Durasi (menit)" required>
        <button type="submit" name="tambah">Tambah Tugas</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Deskripsi</th>
                <th>Durasi (menit)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tugas): ?>
                <?php foreach ($tugas as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= htmlspecialchars($t['deskripsi']) ?></td>
                        <td><?= $t['waktu'] ?></td>
                        <td class="actions">
                            <a href="?hapus=<?= $t['id'] ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
                            <!-- Tambahan fitur edit bisa diimplementasi nanti -->
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Belum ada tugas.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    <div class="footer">
        &copy; <?= date('Y') ?> Aplikasi CRUD Tugas. Estetik & Kalem ✨
    </div>
</div>
</body>
</html>
