<?php
include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body{
            background-color: #f0f0f0;
            gap: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        <h1>Welcome to the system</h1>
        <?php
        if (isset($_SESSION['username'])) {
            echo "Welcome ".$_SESSION['username'];
        }else{
            header('Location: login.php');
        }
        ?>
        <a href="logout.php">Logout</a>
        <br>
        <?php
        // handle form
        if (isset($_POST['fullname']) && isset($_POST['birthday']) && isset($_POST['address']) && isset($_POST['disease'])) {
            $fullname = $_POST['fullname'];
            $birthday = $_POST['birthday'];
            $address = $_POST['address'];
            $disease = $_POST['disease'];
            // check patient in db. If not exist, insert new patient. If exist, update patient info and disease
            $sql = "SELECT * FROM patients WHERE full_name = ? AND birthday = ? AND address = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fullname, $birthday, $address]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                // update disease_history
                $sql = "INSERT INTO disease_history (patient_id, disease) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$result['id'], $disease]);

                echo "Update disease successfully";
            } else {
                // insert new patient
                $sql = "INSERT INTO patients (full_name, birthday, address) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$fullname, $birthday, $address]);
                // last insert id
                $last_id = $conn->lastInsertId();
                // insert disease to disease_history
                $sql = "INSERT INTO disease_history (patient_id, disease) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$last_id, $disease]);

                echo "Insert new patient successfully";
            }
        }
        ?>
        <form method="POST">
            <!-- Full name, birthday, address -->
            <h1>Personal information</h1>
            <label for="fullname">Full name:</label>
            <input type="text" id="fullname" name="fullname"><br><br>

            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday"><br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address"><br><br>

            <!-- disease -->
            <h1>Disease info</h1>
            <label for="disease">Disease:</label>
            <input type="text" id="disease" name="disease"><br><br>


            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="container">
        <h1>Patients list</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Full name</th>
                <th>Birthday</th>
                <th>Address</th>
                <th>Details</th>
            </tr>
            <?php
            $sql = "SELECT * FROM patients";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['full_name']."</td>";
                echo "<td>".$row['birthday']."</td>";
                echo "<td>".$row['address']."</td>";
                echo "<td><a href='details.php?id=".$row['id']."'>Details</a></td>";
                echo "</tr>";
            }
            ?>
    </div>
</body>
</html>