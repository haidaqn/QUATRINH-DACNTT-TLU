<?php
include 'database.php';
// check logged by session
if (isset($_SESSION['username'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
}

.container {
    margin: 100px auto;
    width: 350px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container h1 {
    text-align: center;
    color: #333;
}

.container form {
    margin-top: 20px;
}

.container label {
    display: block;
    margin-bottom: 5px;
    color: #666;
}

.container input[type="text"],
.container input[type="password"],
.container input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.container input[type="submit"] {
    background-color: #4caf50;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.container input[type="submit"]:hover {
    background-color: #45a049;
}

.error-msg {
    color: red;
    text-align: center;
}
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <?php
            // check login from form
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                echo "Username: $username<br>";
                echo "Password: ".md5($password)."<br>";
                $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username, md5($password)]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    echo "Login successfully";
                    $_SESSION['username'] = $username;
                    header('Location: index.php');
                } else {
                    echo "Login failed";
                }
            }
            ?>
            <!-- Full name, birthday, address -->
            <h1 class='login'>Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>