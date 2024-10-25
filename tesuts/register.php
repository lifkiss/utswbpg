<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "concert_system");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email']; 
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $username, $email, $password); 

    if ($stmt->execute()) {
        $message = "<div style='color: #2E8B57; text-align: center; padding: 0.15rem; border-radius: 0.5rem;'>Registrasi berhasil. Silakan login.</div>";
    } else {
        $message = "<div style='color: #960019; text-align: center; padding: 0.15rem; border-radius: 0.5rem;'>Gagal registrasi: " . $conn->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="min-height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; background-image: url('uploads/bg-login.png'); background-size: cover; background-position: center;">

    <a href="index.php" style="position: absolute; top: 20px; left: 20px; text-decoration: none; color: white; font-size: 1.5rem;">&#8592; Kembali</a> 

    <div style="background-color: rgba(255, 255, 255, 0.6); padding: 2rem; border-radius: 0.5rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px;">
        <h2 style="font-size: 1.875rem; font-weight: bold; text-align: center; color: #7E22CE; margin-bottom: 1.5rem;">Registrasi</h2>

        <?php if ($message): ?>
            <div style="margin-bottom: 1rem;"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <label for="username" style="display: block; font-size: 1.125rem; font-weight: medium; color: #374151;">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    style="width: 100%; margin-top: 0.25rem; padding: 0.5rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; color: black; outline: none; transition: ring 0.2s;"
                    onfocus="this.style.borderColor='#7E22CE'; this.style.boxShadow='0 0 0 2px rgba(126, 34, 206, 0.5)';" 
                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none';"
                >
            </div>

            <div>
                <label for="email" style="display: block; font-size: 1.125rem; font-weight: medium; color: #374151;">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    style="width: 100%; margin-top: 0.25rem; padding: 0.5rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; color: black; outline: none; transition: ring 0.2s;"
                    onfocus="this.style.borderColor='#7E22CE'; this.style.boxShadow='0 0 0 2px rgba(126, 34, 206, 0.5)';" 
                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none';"
                >
            </div>

            <div>
                <label for="password" style="display: block; font-size: 1.125rem; font-weight: medium; color: #374151;">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    style="width: 100%; margin-top: 0.25rem; padding: 0.5rem; border: 1px solid #D1D5DB; border-radius: 0.375rem; color: black; outline: none; transition: ring 0.2s;"
                    onfocus="this.style.borderColor='#7E22CE'; this.style.boxShadow='0 0 0 2px rgba(126, 34, 206, 0.5)';" 
                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none';"
                >
            </div>

            <button 
                type="submit" 
                style="width: 100%; background-color: #6D28D9; color: white; padding: 0.5rem; border-radius: 0.5rem; transition: background-color 0.2s;"
                onmouseover="this.style.backgroundColor='#5B21B6';" 
                onmouseout="this.style.backgroundColor='#6D28D9';"
            >
                Daftar
            </button>
        </form>

        <footer style="margin-top: 1.5rem; text-align: center;">
            <p style="color: #4B5563;">
                Sudah punya akun? 
                <a href="login.php" style="color: #7E22CE; text-decoration: none;" 
                onmouseover="this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';">Login di sini</a>
            </p>
        </footer>
    </div>

</body>
</html>