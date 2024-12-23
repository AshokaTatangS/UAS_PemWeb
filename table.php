<?php
session_start();

if (isset($_GET['logout'])) {
    // Hapus semua cookie
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/'); // Hapus cookie dengan mengatur waktu kadaluwarsa
        }
    }

    session_destroy(); // Hancurkan session
    header("Location: auth.php"); // Arahkan ke halaman login
    exit();
}


class DataMahasiswa
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addData($name, $nim, $major, $address, $gender)
    {
        if ($this->validate($name, $nim, $major, $address, $gender)) {
            try {
                $stmt = $this->db->prepare("INSERT INTO mahasiswa (name, nim, major, address, gender, browser, ip_address) VALUES (:name, :nim, :major, :address, :gender, :browser, :ip_address)");
                $stmt->execute([
                    ':name' => htmlspecialchars($name),
                    ':nim' => htmlspecialchars($nim),
                    ':major' => htmlspecialchars($major),
                    ':address' => htmlspecialchars($address),
                    ':gender' => htmlspecialchars($gender),
                    ':browser' => $_SERVER['HTTP_USER_AGENT'],
                    ':ip_address' => $_SERVER['REMOTE_ADDR'],
                ]);
            } catch (PDOException $e) {
                throw new Exception("Gagal menyimpan data: " . $e->getMessage());
            }
        } else {
            throw new Exception("Semua field harus diisi!");
        }
    }

    public function updateData($id, $name, $nim, $major, $address, $gender)
    {
        try {
            $stmt = $this->db->prepare("UPDATE mahasiswa SET name = :name, nim = :nim, major = :major, address = :address, gender = :gender WHERE id = :id");
            $stmt->execute([
                ':name' => htmlspecialchars($name),
                ':nim' => htmlspecialchars($nim),
                ':major' => htmlspecialchars($major),
                ':address' => htmlspecialchars($address),
                ':gender' => htmlspecialchars($gender),
                ':id' => $id,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Gagal mengubah data: " . $e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Gagal menghapus data: " . $e->getMessage());
        }
    }

    public function getData()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM mahasiswa ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Gagal mengambil data: " . $e->getMessage());
        }
    }

    private function validate($name, $nim, $major, $address, $gender)
    {
        return !empty($name) && !empty($nim) && !empty($major) && !empty($address) && !empty($gender);
    }
}

// Koneksi ke database
try {
    $db = new PDO('mysql:host=localhost;dbname=uas_web', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

$dataMahasiswa = new DataMahasiswa($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $dataMahasiswa->updateData($_POST['id'], $_POST['name'], $_POST['nim'], $_POST['major'], $_POST['address'], $_POST['gender']);
    } elseif (isset($_POST['delete'])) {
        $dataMahasiswa->deleteData($_POST['id']);
    } else {
        $dataMahasiswa->addData($_POST['name'], $_POST['nim'], $_POST['major'], $_POST['address'], $_POST['gender']);
    }
}

$data = $dataMahasiswa->getData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
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
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Browser</th>
                    <th>IP Address</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)) : ?>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['nim']) ?></td>
                            <td><?= htmlspecialchars($row['major']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['browser']) ?></td>
                            <td><?= htmlspecialchars($row['ip_address']) ?></td>
                            <td>
                                <button 
                                    class="edit-btn" 
                                    onclick="showEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', '<?= htmlspecialchars($row['nim']) ?>', '<?= htmlspecialchars($row['major']) ?>', '<?= htmlspecialchars($row['address']) ?>', '<?= htmlspecialchars($row['gender']) ?>')">
                                    Edit
                                </button>
                                <form id="delete-form-<?= $row['id'] ?>" action="table.php" method="POST" style="display:none;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="delete" value="1">
                                </form>
                                <button 
                                    class="delete-btn" 
                                    onclick="showConfirmationModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nim']) ?>')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal Edit -->
    <div class="modal-overlay" id="edit-modal">
        <div class="modal">
            <form id="edit-form" action="table.php" method="POST">
                <input type="hidden" name="id" id="edit-id">
                <div>
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required>
                </div>
                <div>
                    <label for="major">Jurusan:</label>
                    <select id="major" name="major" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="TI">Teknik Informatika</option>
                        <option value="SI">Sistem Informasi</option>
                        <option value="DKV">Desain Komunikasi Visual</option>
                    </select>
                </div>
                <div>
                    <label for="address">Alamat:</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                <div>
                    <label for="gender">Jenis Kelamin:</label>
                    <select id="gender" name="gender" required>
                        <option value="">-- Pilih Gender --</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="save-btn" name="update">Simpan</button>
                <button type="button" class="cancel-btn" onclick="closeEditModal()">Batal</button>
            </form>
        </div>
    </div>
</body>
</html>
