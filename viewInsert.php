<!DOCTYPE html>
<html>

<head>
    <title>View Insert</title>
    <style>
    table,
    td,
    th {
        border: 2px solid black;
        border-collapse: collapse;
        width: 500px;
        height: 50px;
    }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>Id File</td>
            <td>File Name</td>
            <td>File Upload</td>
            <td>Description</td>
            <td>Delete File</td>
            <td>Update File</td>

        </tr>


    <?php
    
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=test2db', 'root','');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $select = "SELECT * FROM upload";
        $stmt = $pdo->query($select);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fileId = $row['id'];
            $fileName = $row['fileName'];
            $fileUpload = $row['fileUpload'];
            $description = $row['fileDescription'];

        ?>
          <tr>
            <td><?php echo $fileId; ?></td>
            <td><?php echo $fileName; ?></td>
            <td><img src="file/<?php echo $fileUpload; ?>" width="80" height="60"> </td>
            <td><?php echo $description; ?></td>
            <td><a href="delete.php?delete=<?php echo $fileId; ?>" onclick="return confirm('A jeni i sigurt?')">Delete</a></td>
            <td><a href="update.php?update=<?php echo $fileId; ?>">Update</a></td>
        </tr>
        <?php
        }
     }catch (PDOException $e) {
        echo "Cnnection failed: " .$e->getMessage();
     }
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    