<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $host = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "faq"; 

    // Connect to the database
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user credentials from the database
        $stmt = $pdo->prepare("SELECT email, user_type FROM Users WHERE email = :email AND password = MD5(:password)");
        $stmt->bindParam(':email', $_POST['username']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['user_type'])) {
            // Set session variables
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect based on user type
            if ($user['user_type'] == 'ADMIN') {
                header("Location: /admin1.php");
                exit();
            } elseif ($user['user_type'] == 'INSTRUCTOR') {
                header("Location: /admin2.php");
                exit();
            } else {
                // Add handling for any future user types/scenarios
            }
        } else {
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link rel="stylesheet" href="styles.css" href='https://fonts.googleapis.com/css?family=PT Serif'>
</head>

<body>
    <header>
        <h1>Admin Login</h1>
    </header>

    <main>
        <!-- Admin login form -->
        <form id="adminLoginForm" action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </main>
</body>

</html>