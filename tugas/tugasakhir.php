<?php
include 'koneksi.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $mahasiswa_id = $_POST['mahasiswa_id'] ?? '';
    $dosen_id = $_POST['dosen_id'] ?? '';
    $status = $_POST['status'] ?? 'Draft';

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO tugas_akhir (judul, mahasiswa_id, dosen_id, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $judul, $mahasiswa_id, $dosen_id, $status);
        $stmt->execute();
        $stmt->close();
        header('Location: tugasakhir.php');
        exit;
    } elseif ($action === 'edit' && $id) {
        $stmt = $conn->prepare("UPDATE tugas_akhir SET judul = ?, mahasiswa_id = ?, dosen_id = ?, status = ? WHERE id = ?");
        $stmt->bind_param("siisi", $judul, $mahasiswa_id, $dosen_id, $status, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: tugasakhir.php');
        exit;
    }
}

if ($action === 'delete' && $id) {
    $stmt = $conn->prepare("DELETE FROM tugas_akhir WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: tugasakhir.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Tugas Akhir Management</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<header><h1>Tugas Akhir Management</h1></header>
<nav><a href="index.php">Home</a></nav>
<main>
<?php if ($action === 'add' || ($action === 'edit' && $id)):
    if ($action === 'edit') {
        $stmt = $conn->prepare("SELECT * FROM tugas_akhir WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tugas = $result->fetch_assoc();
        $stmt->close();
    }
?>
<h2><?php echo $action === 'add' ? 'Tambah' : 'Edit'; ?> Tugas Akhir</h2>
<form method="post" action="tugasakhir.php?action=<?php echo htmlspecialchars($action) . ($action === 'edit' ? '&id=' . intval($id) : ''); ?>">
    <label for="judul">Judul:</label>
    <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($tugas['judul'] ?? ''); ?>" required />

    <label for="mahasiswa_id">Mahasiswa:</label>
    <select id="mahasiswa_id" name="mahasiswa_id" required>
        <option value="">Pilih Mahasiswa</option>
        <?php
        $mahasiswa_result = $conn->query("SELECT * FROM mahasiswa ORDER BY nama ASC");
        while ($mhs = $mahasiswa_result->fetch_assoc()) {
            $selected = (isset($tugas['mahasiswa_id']) && $tugas['mahasiswa_id'] == $mhs['id']) ? 'selected' : '';
            echo '<option value="' . $mhs['id'] . '" ' . $selected . '>' . htmlspecialchars($mhs['nama']) . ' (' . htmlspecialchars($mhs['nim']) . ')</option>';
        }
        ?>
    </select>

    <label for="dosen_id">Dosen:</label>
    <select id="dosen_id" name="dosen_id" required>
        <option value="">Pilih Dosen</option>
        <?php
        $dosen_result = $conn->query("SELECT * FROM dosen ORDER BY nama ASC");
        while ($dsn = $dosen_result->fetch_assoc()) {
            $selected = (isset($tugas['dosen_id']) && $tugas['dosen_id'] == $dsn['id']) ? 'selected' : '';
            echo '<option value="' . $dsn['id'] . '" ' . $selected . '>' . htmlspecialchars($dsn['nama']) . ' (' . htmlspecialchars($dsn['nidn']) . ')</option>';
        }
        ?>
    </select>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <?php
        $statuses = ['Draft', 'Submitted', 'Approved', 'Rejected'];
        $current_status = $tugas['status'] ?? 'Draft';
        foreach ($statuses as $st) {
            $selected = ($current_status === $st) ? 'selected' : '';
            echo '<option value="' . $st . '" ' . $selected . '>' . $st . '</option>';
        }
        ?>
    </select>

    <button type="submit">Simpan</button>
    <a href="tugasakhir.php" class="button">Batal</a>
</form>
<?php else: ?>
<h2>Daftar Tugas Akhir</h2>
<a href="tugasakhir.php?action=add" class="button">Tambah Tugas Akhir</a>
<table>
<thead>
    <tr>
        <th>Judul</th>
        <th>Mahasiswa</th>
        <th>Dosen</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$sql = "SELECT tugas_akhir.*, mahasiswa.nama AS mhs_nama, mahasiswa.nim AS mhs_nim, dosen.nama AS dosen_nama, dosen.nidn AS dosen_nidn 
        FROM tugas_akhir 
        JOIN mahasiswa ON tugas_akhir.mahasiswa_id = mahasiswa.id 
        JOIN dosen ON tugas_akhir.dosen_id = dosen.id 
        ORDER BY tugas_akhir.id DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
    echo "<td>" . htmlspecialchars($row['mhs_nama']) . " (" . htmlspecialchars($row['mhs_nim']) . ")</td>";
    echo "<td>" . htmlspecialchars($row['dosen_nama']) . " (" . htmlspecialchars($row['dosen_nidn']) . ")</td>";
    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
    echo '<td>
            <a href="tugasakhir.php?action=edit&id=' . intval($row['id']) . '">Edit</a> | 
            <a href="tugasakhir.php?action=delete&id=' . intval($row['id']) . '" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</a>
          </td>';
    echo "</tr>";
}
?>
</tbody>
</table>
<?php endif; ?>
</main>
</body>
</html>
