<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard - Aplikasi Tugas Akhir</title>
<link rel="stylesheet" href="style.css" />
<style>
  /* Additional quick styling for the dashboard */
  body {
    font-family: Arial, sans-serif;
    background: #f4f7f8;
    margin: 0;
    padding: 0;
  }
  header {
    background: #2c3e50;
    padding: 1rem 0;
    color: white;
    text-align: center;
  }
  main {
    padding: 2rem;
    max-width: 600px;
    margin: auto;
  }
  h1 {
    margin-bottom: 1rem;
  }
  nav a {
    text-decoration: none;
    color: #fff;
    background: #3498db;
    padding: 1rem 2rem;
    margin: 1rem;
    display: inline-block;
    border-radius: 6px;
    font-weight: bold;
    transition: background 0.3s;
  }
  nav a:hover {
    background: #2980b9;
  }
  @media (max-width: 480px) {
    nav a {
      display: block;
      margin: 0.5rem auto;
      width: 80%;
      text-align: center;
    }
  }
</style>
</head>
<body>
<header>
  <h1>Aplikasi Tugas Akhir</h1>
</header>
<main>
  <nav>
    <a href="mahasiswa.php">Kelola Mahasiswa</a>
    <a href="dosen.php">Kelola Dosen</a>
    <a href="tugasakhir.php">Kelola Tugas Akhir</a>
  </nav>
</main>
</body>
</html>
