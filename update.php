<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title> Update </title>
</head>

<body>
    <?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=test2db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_GET['update'])){
            $update_id = $_GET['update'];
            $select = "SELECT * FROM upload WHERE id=:id";
            $stmt = $pdo->prepare($select);
            $stmt->bindParam(':id', $update_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <form method='post' action="update_ID.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        File Name:<input type="text" name="fileName" value="<?php echo $row['fileName'];?>">
        <br><br>
        File Upload:<input type="file" name="fileUpload" placeholder="../file/<?php echo $row['fileUpload'];?>">
        <img src="../file/<?php echo $row['fileUpload'];?>" width="100" height="100">
        <br><br>
        File Description:<textarea name="description" cols="30" rows="20"><?php echo $row['fileDescription'];?>
                </textarea>
        <br><br>
        <input type="submit" name="update" value="Update">
    </form>
    <?php 
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>
</body>

</html>