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

// Mengambil daftar konser
$result = $conn->query("SELECT * FROM concerts");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konser</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .register-button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .register-button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">Daftar Konser</h1>

    <table>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Max Participants</th>
            <th>Registered Participants</th>
            <th>Image</th>
            <th>Register</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            // Menghitung jumlah pendaftar untuk konser ini
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM registrations WHERE concert_id = ?");
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
            $stmt->bind_result($total_registered);
            $stmt->fetch();
            $stmt->close();
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo htmlspecialchars($row['max_participants']); ?></td>
                <td><?php echo htmlspecialchars($total_registered); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Concert Image"></td>
                <td>
                    <form method="GET" action="register.php">
                        <input type="hidden" name="concert_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="register-button">Register</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>