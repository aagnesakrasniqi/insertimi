<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Insertimi i produkteve</title>
</head>

<body>
    <form method="post" action="insertimi.php" enctype="multipart/form-data">
        File Name: <input type="text" name="fileName"><br><br>
        File Upload: <input type="file" name="fileUpload"><br><br>
        File Description: <textarea name='fileDescription' cols='30' rows='15'></textarea><br><br>
        <input type="submit" name="upload" value="Insert">
        <input type="reset" name="cancel" value="Cancel">
    </form>
    <a href='viewInsert.php'>Home</a>
</body>

</html>

<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test2db', 'root', '');

    if (isset($_POST['upload'])) {
        $fileName = $_POST['fileName'];
        $fileDescription = $_POST['fileDescription'];
        $fileUpload = $_FILES['fileUpload']['name'];
        $fileUpload_tmp = $_FILES['fileUpload']['tmp_name'];

        if ($fileName == '' or $fileUpload == '') {
            echo "<script>alert('Any input is Empty');</script>";
        } else {
            // Check if file already exists
            $select = "SELECT * FROM upload WHERE fileName=:fileName OR fileUpload=:fileUpload LIMIT 1";
            $stmt = $pdo->prepare($select);
            $stmt->bindParam(':fileName', $fileName);
            $stmt->bindParam(':fileUpload', $fileUpload);
            $stmt->execute();
            $exist = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($exist) {
                echo "<script>alert('This file already exists!');</script>";
            } else {
                move_uploaded_file($fileUpload_tmp, "file/$fileUpload");

                $uploadFile = "INSERT INTO upload(fileName, fileUpload, fileDescription)
                               VALUES(:fileName, :fileUpload, :fileDescription)";
                $stmt = $pdo->prepare($uploadFile);
                $stmt->bindParam(':fileName', $fileName);
                $stmt->bindParam(':fileUpload', $fileUpload);
                $stmt->bindParam(':fileDescription', $fileDescription);

                if ($stmt->execute()) {
                    echo "<script>alert('File is Upload');</script>";
                } else {
                    echo "<script>alert('Upload Failed!');</script>";
                }
            }
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>