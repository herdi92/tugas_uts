<?php
include 'koneksi.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nidn = $_POST['nidn'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $telp = $_POST['telp'] ?? '';

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO dosen (nidn, nama, email, telp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nidn, $nama, $email, $telp);
        $stmt->execute();
        $stmt->close();
        header('Location: dosen.php');
        exit;
    } elseif ($action === 'edit' && $id) {
        $stmt = $conn->prepare("UPDATE dosen SET nidn = ?, nama = ?, email = ?, telp = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nidn, $nama, $email, $telp, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: dosen.php');
        exit;
    }
}

if ($action === 'delete' && $id) {
    $stmt = $conn->prepare("DELETE FROM dosen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: dosen.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Dosen Management</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<header><h1>Dosen Management</h1></header>
<nav><a href="index.php">Home</a></nav>
<main>

<?php if ($action === 'add' || ($action === 'edit' && $id)): 
    if ($action === 'edit') {
        $stmt = $conn->prepare("SELECT * FROM dosen WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dsn = $result->fetch_assoc();
        $stmt->close();
    }
?>

<h2><?php echo $action === 'add' ? 'Tambah' : 'Edit'; ?> Dosen</h2>
<form method="post" action="dosen.php?action=<?php echo htmlspecialchars($action) . ($action === 'edit' ? '&id=' . intval($id) : ''); ?>">
    <label for="nidn">NIDN:</label><br />
    <input type="text" name="nidn" id="nidn" value="<?php echo htmlspecialchars($dsn['nidn'] ?? ''); ?>" required /><br />
    <label for="nama">Nama:</label><br />
    <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($dsn['nama'] ?? ''); ?>" required /><br />
    <label for="email">Email:</label><br />
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($dsn['email'] ?? ''); ?>" /><br />
    <label for="telp">Telepon:</label><br />
    <input type="text" name="telp" id="telp" value="<?php echo htmlspecialchars($dsn['telp'] ?? ''); ?>" /><br /><br />
    <button type="submit">Simpan</button>
    <a href="dosen.php">Batal</a>
</form>

<?php else: ?>

<h2>Daftar Dosen</h2>
<a href="dosen.php?action=add" class="button">Tambah Dosen</a>
<table>
<thead>
<tr>
    <th>NIDN</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$result = $conn->query("SELECT * FROM dosen ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['nidn']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['telp']) . "</td>";
    echo '<td><a href="dosen.php?action=edit&id=' . intval($row['id']) . '">Edit</a> | ';
    echo '<a href="dosen.php?action=delete&id=' . intval($row['id']) . '" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</a></td>';
    echo "</tr>";
}
?>
</tbody>
</table>

<?php endif; ?>

</main>
</body>
</html>
