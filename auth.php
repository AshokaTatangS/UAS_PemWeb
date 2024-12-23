<?php
session_start(); // Memulai session

// Koneksi Database
class Database {
    private $host = "localhost";
    private $db_name = "uas_web";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Kelas User untuk Login dan Register
class User {
    private $conn;
    private $table = "akun";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                // Login berhasil: Simpan username ke session
                $_SESSION['user'] = $user['username'];
                setcookie('user', $user['username'], time() + (86400 * 7), "/"); // Cookie berlaku 7 hari
                return true;
            }
        }
        return false;
    }

    public function register($username, $password) {
        if (strlen($password) < 8) {
            return "Password harus memiliki minimal 8 karakter.";
        }

        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Username sudah digunakan.";
        }

        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);

        if ($stmt->execute()) {
            return "Akun berhasil dibuat. Silakan login.";
        } else {
            return "Terjadi kesalahan. Coba lagi.";
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    public function logout() {
        session_destroy();
        setcookie('user', '', time() - 3600, "/"); // Hapus cookie
        header("Location: auth.php");
        exit();
    }
}

$db = new Database();
$connection = $db->connect();
$user = new User($connection);

$message = "";
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if ($page === 'login') {
        if ($user->login($username, $password)) {
            header("Location: form.php"); // Redirect ke form.php setelah login berhasil
            exit();
        } else {
            $message = "Username atau password salah.";
        }
    } elseif ($page === 'register') {
        $message = $user->register($username, $password);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($page); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4682b4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .container h2 {
            color: #4682b4;
        }

        .container input,
        .container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .container input {
            border: 1px solid #ccc;
        }

        .container button {
            background-color: #4682b4;
            color: white;
            border: none;
            cursor: pointer;
        }

        .container p {
            margin-top: 10px;
        }

        .container a {
            color: #4682b4;
            text-decoration: none;
        }

        .error-message {
            color: red;
            font-size: 12px;
            text-align: left;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" id="authForm">
            <h2><?php echo ucfirst($page); ?></h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" minlength="8" required>
            <button type="submit"><?php echo ucfirst($page); ?></button>
            <p><?php echo $message; ?></p>
            <?php if ($page === 'login'): ?>
                <p>Belum punya akun? <a href="?page=register">Register</a></p>
            <?php else: ?>
                <p>Sudah punya akun? <a href="?page=login">Login</a></p>
            <?php endif; ?>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("authForm");
            const inputs = form.querySelectorAll("input[required]");

            form.addEventListener("submit", function (event) {
                let isValid = true;

                inputs.forEach(input => {
                    const errorElement = input.nextElementSibling;

                    // Hapus pesan error sebelumnya
                    if (errorElement && errorElement.classList.contains("error-message")) {
                        errorElement.remove();
                    }

                    // Periksa apakah input kosong
                    if (!input.value.trim()) {
                        isValid = false;

                        // Tambahkan pesan error
                        const error = document.createElement("div");
                        error.classList.add("error-message");
                        error.textContent = "Kolom ini tidak boleh kosong";
                        input.parentNode.insertBefore(error, input.nextSibling);
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                } else {
                    // Simpan username ke localStorage
                    const usernameInput = document.querySelector("input[name='username']");
                    if (usernameInput) {
                        localStorage.setItem('username', usernameInput.value);
                    }
                }
            });

            // Tampilkan pesan sambutan jika cookie ditemukan
            const username = localStorage.getItem('username');
            const userCookie = document.cookie.split('; ').find(row => row.startsWith('user='));
            if (userCookie) {
                const loggedInUser = userCookie.split('=')[1];
                if (loggedInUser) {
                    alert(`Selamat datang kembali, ${decodeURIComponent(loggedInUser)}!`);
                }
            }
        });
    </script>
</body>
</html>