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

// Menangani login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StubHub - Tickets & Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">

    <!-- HEADER / NAVBAR -->
    <header class="bg-orange-400 p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="images/logo.png" alt="StubHub Logo" class="h-12">
            <h1 class="text-black text-xl font-bold">StubHub</h1>
        </div>
        <nav class="space-x-6">
            <a href="#home" class="text-black font-semibold hover:text-white">Home</a>
            <a href="#events" class="text-black font-semibold hover:text-white">Events</a>
            <a href="#tickets" class="text-black font-semibold hover:text-white">Tickets</a>
            <a href="#contact" class="text-black font-semibold hover:text-white">Contact</a>
        </nav>
    </header>

    <!-- CAROUSEL -->
    <section class="relative overflow-hidden">
        <div class="carousel flex transition-transform duration-500">
            <div class="min-w-full">
                <img src="https://via.placeholder.com/1200x400" class="w-full" alt="Event 1">
                <div class="absolute bottom-5 left-5 text-white bg-black bg-opacity-50 p-2 text-xl">Discover the Latest Concerts!</div>
            </div>
            <div class="min-w-full">
                <img src="https://via.placeholder.com/1200x400" class="w-full" alt="Event 2">
                <div class="absolute bottom-5 left-5 text-white bg-black bg-opacity-50 p-2 text-xl">Find Sports Tickets Near You</div>
            </div>
            <div class="min-w-full">
                <img src="https://via.placeholder.com/1200x400" class="w-full" alt="Event 3">
                <div class="absolute bottom-5 left-5 text-white bg-black bg-opacity-50 p-2 text-xl">Book Your Favorite Theater Shows</div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="p-8">
        <!-- EVENTS SECTION -->
        <section id="events" class="mb-10">
            <h2 class="text-2xl font-bold mb-6">Upcoming Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow rounded">
                    <h3 class="text-xl font-semibold mb-2">Concert: Taylor Swift</h3>
                    <p class="text-gray-700 mb-4">Date: October 25, 2024</p>
                    <button class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">Buy Tickets</button>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <h3 class="text-xl font-semibold mb-2">Soccer: Real Madrid vs Barcelona</h3>
                    <p class="text-gray-700 mb-4">Date: November 1, 2024</p>
                    <button class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">Buy Tickets</button>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <h3 class="text-xl font-semibold mb-2">Theater: Hamilton</h3>
                    <p class="text-gray-700 mb-4">Date: November 5, 2024</p>
                    <button class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">Book Now</button>
                </div>
            </div>
        </section>

        <!-- TICKETS SECTION -->
        <section id="tickets" class="mb-10">
            <h2 class="text-2xl font-bold mb-6">Available Tickets</h2>
            <table class="table-auto w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4 text-left">Event</th>
                        <th class="p-4 text-left">Date</th>
                        <th class="p-4 text-left">Price</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-4">Concert: Taylor Swift</td>
                        <td class="p-4">October 25, 2024</td>
                        <td class="p-4">$120</td>
                        <td class="p-4 text-center">
                            <button class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">Buy Now</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4">Soccer: Real Madrid vs Barcelona</td>
                        <td class="p-4">November 1, 2024</td>
                        <td class="p-4">$90</td>
                        <td class="p-4 text-center">
                            <button class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">Buy Now</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-orange-400 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-bold mb-4">About Us</h4>
                <p>StubHub is your one-stop platform for tickets to concerts, sports, and theater events.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <a href="#home" class="block mb-2">Home</a>
                <a href="#events" class="block mb-2">Events</a>
                <a href="#tickets" class="block mb-2">Tickets</a>
                <a href="#contact" class="block">Contact</a>
            </div>
            <div>
                <h4 class="font-bold mb-4">Follow Us</h4>
                <a href="#" class="block mb-2"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#" class="block mb-2"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="#" class="block"><i class="fab fa-instagram"></i> Instagram</a>
            </div>
        </div>
        <p class="text-center mt-4">&copy; 2024 StubHub. All rights reserved.</p>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>
']; // Menyimpan role pengguna

            // Arahkan berdasarkan role
            if ($row['role'] === 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: list_concert.php");
                exit();
            }
        } else {
            echo "Username atau password salah.";
        }
    } else {
        echo "Username atau password salah.";
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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p><a href="register.php">Daftar akun baru</a></p>
</body>
</html>
