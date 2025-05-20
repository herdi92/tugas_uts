<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Aplikasi Tugas Akhir</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <h1>Aplikasi Tugas Akhir</h1>
</header>
<nav>
    <div class="menu">
        <a href="mahasiswa.php">Kelola Mahasiswa</a>
        <a href="dosen.php">Kelola Dosen</a>
        <a href="tugasakhir.php">Kelola Tugas Akhir</a>
    </div>
    <a href="logout.php" class="logout">Logout</a> <!-- Logout Button -->
</nav>
<main>
    <div class="welcome-card">
        <h2>Welcome to the Dashboard</h2>
        <p>Manage your academic data efficiently with our easy-to-use interface.</p>
    </div>
    <div class="action-cards">
        <div class="card">
            <h3>Kelola Mahasiswa</h3>
            <p>Manage student records, add new students, and edit existing information.</p>
            <a href="mahasiswa.php" class="button">Go to Mahasiswa</a>
        </div>
        <div class="card">
            <h3>Kelola Dosen</h3>
            <p>Manage lecturer records, add new lecturers, and edit existing information.</p>
            <a href="dosen.php" class="button">Go to Dosen</a>
        </div>
        <div class="card">
            <h3>Kelola Tugas Akhir</h3>
            <p>Manage thesis records, add new theses, and edit existing information.</p>
            <a href="tugasakhir.php" class="button">Go to Tugas Akhir</a>
        </div>
    </div>
</main>
</body>
</html>
