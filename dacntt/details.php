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
        if (isset($_POST['submit'])) {
            $disease = $_POST['disease'];
            $date = $_POST['createDate'];

            if (empty($disease) || empty($date)) {
                echo "Please fill all fields";
            } else {
                try {
                    $sql = "INSERT INTO `disease_history`(`patient_id`, `disease`, `modified_date`) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$id, $disease, $date]);

                    if ($stmt->rowCount() > 0) {
                        echo "Add disease history successfully";
                    } else {
                        echo "Add disease history failed";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
        ?>
        <form method="POST">
            <h1>Disease info</h1>
            <label for="disease">Disease:</label>
            <input type="text" id="disease" name="disease"><br><br>

            <label>Date:</label>
            <input type="datetime-local" id="createDate" name="createDate"><br><br>

            <input type="submit" name="submit" id="submit" value="Submit">
        </form>
    </div>
    <?php
    // edit disease history
    if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];

        // check if disease history exists
        $sql = "SELECT * FROM disease_history WHERE id = ? AND patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$edit_id, $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo "Disease history not found";
            return;
        }
        ?>
        <div class="container">
            <?php
                if(isset($_POST['submitEdit'])){
                    $disease = $_POST['editDisease'];
                    $date = $_POST['editDate'];

                    if(empty($disease) || empty($date)){
                        echo "Please fill all fields";
                        return;
                    }

                    $sql = "UPDATE disease_history SET disease = ?, modified_date = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$disease, $date, $edit_id]);
                    if ($stmt->rowCount() > 0) {
                        echo "Edit disease history successfully";
                    }else{
                        echo "Edit disease history failed";
                    }
                }
            ?>
            <form method="POST">
                <h1>Edit disease info</h1>
                <label for="disease">Disease:</label>
                <input type="text" id="editDisease" name="editDisease" value="<?=$result['disease'];?>"><br><br>

                <label>Date:</label>
                <input type="datetime-local" id="editDate" name="editDate" value="<?=$result['modified_date'];?>"><br><br>

                <input type="submit" name="submitEdit" value="Submit">
            </form>
        </div>
        <?php
    }
    ?>

    <?php
    // delete disease history
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        // check if disease history exists
        $sql = "SELECT * FROM disease_history WHERE id = ? AND patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$delete_id, $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo "Disease history not found";
            return;
        }

        $sql = "DELETE FROM disease_history WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$delete_id]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Delete disease history successfully')</script>";
        }else{
            echo "<script>alert('Delete disease history failed')</script>";
        }
    }
    ?>

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
                echo "<td><a href='/details.php?id=".$id."&edit=".$row['id']."'>Edit</a> | <a href='/details.php?id=".$id."&delete=".$row["id"]."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <a href="index.php">Back to home</a>
    </div>
</body>
</html>