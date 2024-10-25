<?php
session_start();
$conn = new mysqli("localhost", "root", "", "concert_system");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$query = "SELECT u.email, u.username, c.name AS concert_name, r.registration_date 
          FROM registrations r
          JOIN users u ON r.user_id = u.id
          JOIN concerts c ON r.concert_id = c.id
          ORDER BY u.email, r.registration_date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User dan Event</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar User dan Event yang Pernah Terdaftar</h1>
        <table>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Nama Konser</th>
                <th>Tanggal Registrasi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['concert_name']); ?></td>
                <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
