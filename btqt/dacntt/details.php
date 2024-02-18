<?php
include 'database.php';
// check logged by session
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease history for patient #<?=$id;?></title>
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
            <h1>Disease history for patient #<?=$id;?></h1>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Disease</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                <?php
                $sql = "SELECT * FROM disease_history WHERE patient_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$id]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['disease']."</td>";
                    echo "<td>".$row['modified_date']."</td>";
                    echo "<td><a href='?'>Edit</a> | <a href='?'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <br>
            <a href="index.php">Back to home</a>
        </div>
</body>
</html>