<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth.php"); // Redirect ke halaman login jika belum login
    exit();
}

if (isset($_GET['logout'])) {
    // Hapus semua cookie
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/'); // Hapus cookie dengan mengatur waktu kadaluwarsa ke masa lalu
        }
    }

    session_destroy(); // Hancurkan session
    header("Location: auth.php"); // Arahkan ke halaman login
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
        .error-border {
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Form Data Mahasiswa</h1>
        <nav>
            <ul>
                <li><a href="form.php">Form</a></li>
                <li><a href="table.php">Tabel</a></li>
                <li><a href="?logout=true">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form id="studentForm" action="table.php" method="POST">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name">
            <div class="error-message" id="error-name">Kolom ini tidak boleh kosong</div>

            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim">
            <div class="error-message" id="error-nim">Kolom ini tidak boleh kosong</div>

            <label for="major">Jurusan:</label>
            <select id="major" name="major">
                <option value="">-- Pilih Jurusan --</option>
                <option value="TI">Teknik Informatika</option>
                <option value="SI">Sistem Informasi</option>
                <option value="DKV">Desain Komunikasi Visual</option>
            </select>
            <div class="error-message" id="error-major">Kolom ini tidak boleh kosong</div>

            <label>Jenis Kelamin:</label>
            <div>
                <input type="radio" id="gender-male" name="gender" value="Laki-laki">
                <label for="gender-male">Laki-laki</label>
            </div>
            <div>
                <input type="radio" id="gender-female" name="gender" value="Perempuan">
                <label for="gender-female">Perempuan</label>
            </div>
            <div class="error-message" id="error-gender">Kolom ini tidak boleh kosong</div>

            <label for="address">Alamat:</label>
            <textarea id="address" name="address" rows="4"></textarea>
            <div class="error-message" id="error-address">Kolom ini tidak boleh kosong</div>

            <button type="submit">Kirim</button>
        </form>
    </main>

    <script>
        document.getElementById('studentForm').addEventListener('submit', function (e) {
            let isValid = true;

            // Validasi nama
            const name = document.getElementById('name');
            const errorName = document.getElementById('error-name');
            if (name.value.trim() === '') {
                errorName.style.display = 'block';
                name.classList.add('error-border');
                isValid = false;
            } else {
                errorName.style.display = 'none';
                name.classList.remove('error-border');
            }

            // Validasi NIM
            const nim = document.getElementById('nim');
            const errorNim = document.getElementById('error-nim');
            if (nim.value.trim() === '') {
                errorNim.style.display = 'block';
                nim.classList.add('error-border');
                isValid = false;
            } else {
                errorNim.style.display = 'none';
                nim.classList.remove('error-border');
            }

            // Validasi jurusan
            const major = document.getElementById('major');
            const errorMajor = document.getElementById('error-major');
            if (major.value === '') {
                errorMajor.style.display = 'block';
                major.classList.add('error-border');
                isValid = false;
            } else {
                errorMajor.style.display = 'none';
                major.classList.remove('error-border');
            }

            // Validasi gender
            const genderMale = document.getElementById('gender-male');
            const genderFemale = document.getElementById('gender-female');
            const errorGender = document.getElementById('error-gender');
            if (!genderMale.checked && !genderFemale.checked) {
                errorGender.style.display = 'block';
                isValid = false;
            } else {
                errorGender.style.display = 'none';
            }

            // Validasi alamat
            const address = document.getElementById('address');
            const errorAddress = document.getElementById('error-address');
            if (address.value.trim() === '') {
                errorAddress.style.display = 'block';
                address.classList.add('error-border');
                isValid = false;
            } else {
                errorAddress.style.display = 'none';
                address.classList.remove('error-border');
            }

            // Hentikan submit jika ada error
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
