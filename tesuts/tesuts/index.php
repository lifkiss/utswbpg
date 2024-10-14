<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Concert System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #5cb85c;
            font-size: 18px;
            margin: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Concert System</h1>
    <div>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="list_concert.php">View Concerts</a>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Anda telah login sebagai pengguna dengan ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</body>
</html>
