<?php
include 'koneksi.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['telp'] ?? '';

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, email, telp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nim, $nama, $email, $telp);
        $stmt->execute();
        $stmt->close();
        header('Location: mahasiswa.php');
        exit;
    } elseif ($action === 'edit' && $id) {
        $stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, email = ?, telp = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nim, $nama, $email, $telp, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: mahasiswa.php');
        exit;
    }
}

if ($action === 'delete' && $id) {
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: mahasiswa.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Mahasiswa Management</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<header><h1>Mahasiswa Management</h1></header>
<nav><a href="index.php">Home</a></nav>
<main>

<?php if ($action === 'add' || ($action === 'edit' && $id)): 
    if ($action === 'edit') {
        $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $mhs = $result->fetch_assoc();
        $stmt->close();
    }
?>

<h2><?php echo $action === 'add' ? 'Tambah' : 'Edit'; ?> Mahasiswa</h2>
<form method="post" action="mahasiswa.php?action=<?php echo htmlspecialchars($action) . ($action === 'edit' ? '&id=' . intval($id) : ''); ?>">
    <label for="nim">NIM:</label><br />
    <input type="text" name="nim" id="nim" value="<?php echo htmlspecialchars($mhs['nim'] ?? ''); ?>" required /><br />
    <label for="nama">Nama:</label><br />
    <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($mhs['nama'] ?? ''); ?>" required /><br />
    <label for="email">Email:</label><br />
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($mhs['email'] ?? ''); ?>" /><br />
    <label for="telp">Telepon:</label><br />
    <input type="text" name="telp" id="telp" value="<?php echo htmlspecialchars($mhs['telp'] ?? ''); ?>" /><br /><br />
    <button type="submit">Simpan</button>
    <a href="mahasiswa.php">Batal</a>
</form>

<?php else: ?>

<h2>Daftar Mahasiswa</h2>
<a href="mahasiswa.php?action=add" class="button">Tambah Mahasiswa</a>
<table>
<thead>
<tr>
    <th>NIM</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$result = $conn->query("SELECT * FROM mahasiswa ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['telp']) . "</td>";
    echo '<td><a href="mahasiswa.php?action=edit&id=' . intval($row['id']) . '">Edit</a> | ';
    echo '<a href="mahasiswa.php?action=delete&id=' . intval($row['id']) . '" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</a></td>';
    echo "</tr>";
}
?>
</tbody>
</table>

<?php endif; ?>

</main>
</body>
</html>

