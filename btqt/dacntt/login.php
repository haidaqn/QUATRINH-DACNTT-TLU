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
        body{
            background-color: #f0f0f0;
            /* align center */
            display: flex;
            justify-content: center;
        }
        .container {
            display: flex;
            justify-content: center;
            background-color: #fff;
            width: 50%;
            padding: 10px;
            border-radius: 10px;
            /* border dot */
            border: 2px dashed #000;
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
            <h1>Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>