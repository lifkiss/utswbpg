<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "concert_system");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani penambahan konser
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $max_participants = $_POST['max_participants'];
    $description = $_POST['description']; // Menambahkan deskripsi

    // Menangani upload gambar
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Maaf, gambar Anda tidak diupload.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Memperbarui string bind_param untuk memasukkan deskripsi
            $stmt = $conn->prepare("INSERT INTO concerts (name, date, location, max_participants, image, description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisss", $name, $date, $location, $max_participants, $target_file, $description); // Perbaiki tipe
            $stmt->execute();
            $stmt->close();
            echo "Konser berhasil ditambahkan.";
        } else {
            echo "Maaf, ada kesalahan saat mengupload gambar.";
        }
    }
}

// Menangani penghapusan konser
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM concerts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Menangani pengeditan konser
$concert = null; // Inisialisasi variabel konser

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM concerts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $concert = $result->fetch_assoc();
    $stmt->close(); // Menutup statement setelah digunakan
}

// Memperbarui konser
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location']; // Ini adalah string, jadi harus di-bind sebagai 's'
    $max_participants = $_POST['max_participants']; // Ini adalah integer
    $description = $_POST['description']; // Ini adalah string

    // Update gambar jika ada
    $target_file = ""; // Inisialisasi variabel untuk gambar baru
    if (!empty($_FILES["image"]["name"])) {
        // Hanya jika gambar baru diupload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Jika gambar berhasil diupload, update dengan gambar baru
        } else {
            echo "Maaf, ada kesalahan saat mengupload gambar.";
        }
    }

        // Update data konser
        if ($target_file === "") {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $stmt = $conn->prepare("UPDATE concerts SET name = ?, date = ?, location = ?, max_participants = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssissi", $name, $date, $location, $max_participants, $description, $id);
        } else {
            // Jika ada gambar baru, update gambar juga
            $stmt = $conn->prepare("UPDATE concerts SET name = ?, date = ?, location = ?, max_participants = ?, image = ?, description = ? WHERE id = ?");
            $stmt->bind_param("sssissi", $name, $date, $location, $max_participants, $target_file, $description, $id);
        }
    
        if ($stmt->execute()) {
            echo "Konser berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui konser: " . $conn->error;
        }
        $stmt->close();
    }
    
    // Mengambil daftar konser
    $result = $conn->query("SELECT * FROM concerts");
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                background-color: #f2f2f2;
            }
            
            .container {
                max-width: 800px;
                margin: 40px auto;
                padding: 20px;
                background-color: #fff;
                border: 1px solid #ddd;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            
            h1 {
                color: #333;
                font-weight: bold;
                margin-bottom: 20px;
            }
            
            form {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            input[type="text"], input[type="date"], input[type="number"], textarea {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
            }
            
            button[type="submit"] {
                background-color: #ff9900;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            
            button[type="submit"]:hover {
                background-color: #ff69b4;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            
            th {
                background-color: #f2f2f2;
            }
            
            img {
                max-width: 100px;
                max-height: 100px;
                object-fit: cover;
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Welcome Admin</h1>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo isset($concert) ? $concert['id'] : ''; ?>">
                <input type="text" name="name" placeholder="Concert Name" required value="<?php echo isset($concert) ? htmlspecialchars($concert['name']) : ''; ?>">
                <input type="date" name="date" required value="<?php echo isset($concert) ? htmlspecialchars($concert['date']) : ''; ?>">
                <input type="text" name="location" placeholder="Location" required value="<?php echo isset($concert) ? htmlspecialchars($concert['location']) : ''; ?>">
                <input type="number" name="max_participants" placeholder="Max Participants" required min="1" value="<?php echo isset($concert) ? htmlspecialchars($concert['max_participants']) : ''; ?>">
                <textarea name="description" placeholder="Description" required><?php echo isset($concert) ? htmlspecialchars($concert['description']) : ''; ?></textarea>
                <input type="file" name="image">
                <button type="submit" name="<?php echo isset($concert) ? 'update' : 'add'; ?>">
                    <?php echo isset($concert) ? 'Update Concert' : 'Add Concert'; ?>
                </button>
                </form>

<h2>Concert List</h2>

<table>
    <tr>
        <th>Concert Name</th>
        <th>Date</th>
        <th>Location</th>
        <th>Max Participants</th>
        <th>Image</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php while ($concert = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($concert['name']); ?></td>
        <td><?php echo htmlspecialchars($concert['date']); ?></td>
        <td><?php echo htmlspecialchars($concert['location']); ?></td>
        <td><?php echo htmlspecialchars($concert['max_participants']); ?></td>
        <td><img src="<?php echo htmlspecialchars($concert['image']); ?>"></td>
        <td><?php echo htmlspecialchars($concert['description']); ?></td>
        <td>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo $concert['id']; ?>">
                <button type="submit" name="edit">Edit</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo $concert['id']; ?>">
                <button type="submit" name="delete">Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>