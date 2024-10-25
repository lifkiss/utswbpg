<?php
$conn = new mysqli("localhost", "root", "", "concert_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    
    if ($stmt = $conn->prepare($deleteQuery)) {
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $message = "Akun berhasil dihapus.";
        } else {
            $message = "Kesalahan saat menghapus akun: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    }
}

$query = "
    SELECT u.id, u.username, u.email, GROUP_CONCAT(c.name SEPARATOR ', ') AS concerts 
    FROM users u 
    LEFT JOIN registrations r ON u.email = r.email 
    LEFT JOIN concerts c ON r.concert_id = c.id 
    GROUP BY u.id
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-image: url('uploads/bg-login.png'); 
            margin: 0;
            padding: 20px;
            color: #fff; 
        }
        
        h2 {
            color: white;    
            text-align: center;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); 
            border-radius: 8px;
            overflow: hidden; 
            background-color: rgba(128, 0, 128, 0.8); 
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px; 
            text-align: left;
        }
        
        th {
            background-color: #800080; 
            color: white; 
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1); 
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.2); 
        }

        a {
            color: #ffccff; 
            text-decoration: none;
            font-weight: bold; 
        }

        a:hover {
            color: #e0b0ff; 
        }

        @media (max-width: 1200px) {
            th, td {
                padding: 10px;
            }
        }

        @media (max-width: 992px) {
            table {
                display: block; 
                overflow-x: auto; 
                border: none; 
            }

            thead {
                display: none; 
            }

            tr {
                display: block; 
                margin-bottom: 10px; 
                border-bottom: 1px solid #ddd; 
            }

            td {
                display: flex; 
                justify-content: space-between; 
                padding: 10px; 
                text-align: right; 
            }

            td::before {
                content: attr(data-label); 
                font-weight: bold; 
                text-align: left;
                flex: 1; 
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 10px; 
            }

            td {
                padding: 8px; 
            }

            td::before {
                font-size: 14px; 
            }
        }
    </style>
</head>
<body>
    <a href="admin.php" style="color: #ffccff; text-decoration: none; font-weight: bold;">
        &#8592; Kembali ke Admin
    </a>
    <h2>Data Pengguna Terdaftar</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Concerts</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td data-label="ID">' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td data-label="Username">' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td data-label="Email">' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td data-label="Concerts">' . htmlspecialchars($row['concerts']) . '</td>';
                    echo '<td data-label="Aksi"><a href="?delete=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Anda yakin ingin menghapus akun ini?\');">Hapus</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">Error in query: ' . htmlspecialchars($conn->error) . '</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
if (isset($conn)) {
    $conn->close();
}
?>
