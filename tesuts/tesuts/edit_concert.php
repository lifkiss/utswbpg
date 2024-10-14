<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php ");
    exit();
}

$conn = new mysqli("localhost", "root", "", "concert_system");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil detail konser
$id = $_GET['id'];
$concert = $conn->query("SELECT * FROM concerts WHERE id = $id")->fetch_assoc();

// Update konser
if (isset($_POST['update_concert'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = trim($_POST['location']); // Add trimming to remove trailing spaces

    // Validate and sanitize the location value
    $location = mysqli_real_escape_string($conn, $location);

    $stmt = $conn->prepare("UPDATE concerts SET name = ?, date = ?, location = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $date, $location, $id);
    $stmt->execute();

    if (!$stmt->execute()) {
        echo "Error updating concert: " . $stmt->error;
        exit();
    }

    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Concert</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Concert</h1>

    <form method="POST" action="">
        <input type="text" name="name" value="<?php echo htmlspecialchars($concert['name']); ?>" required>
        <input type="date" name="date" value="<?php echo htmlspecialchars($concert['date']); ?>" required>
        <input type="text" name="location" value="<?php echo htmlspecialchars($concert['location']); ?>" required>
        <button type="submit" name="update_concert">Update Concert</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>