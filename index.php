<?php
include("config.php");

if (isset($_POST['search'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM userportal1 WHERE Id = '$id'";
    $data = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($data);
    if (!$result) {
        echo "<script>alert('ID doesn\'t exist')</script>";
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];
    $photoType = $_FILES['photo']['type'];

    if ($id != '' && $username != '' && $fullname != '' && $email != '' && $address != '') {
        if ($photoError === 0) {
            if ($photoSize < 5000000) { // 5MB limit
                $photoContent = addslashes(file_get_contents($photoTmpName));

                $sql = "INSERT INTO userportal1 (Id, username, fullname, email, address, photo) VALUES ('$id','$username', '$fullname', '$email', '$address', '$photoContent')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Hurry! Data Inserted Successfully')</script>";
                } else {
                    echo "<script>alert('Failed to insert: " . mysqli_error($conn) . "')</script>";
                }
            } else {
                echo "<script>alert('Your file is too large.')</script>";
            }
        } else {
            echo "<script>alert('There was an error uploading your file.')</script>";
        }
    } else {
        echo "<script>alert('Fill all Details')</script>";
    }
}

if (isset($_POST['modify'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];
    $photoType = $_FILES['photo']['type'];

    if ($photoName != "") {
        if ($photoError === 0) {
            if ($photoSize < 5000000) { // 5MB limit
                $photoContent = addslashes(file_get_contents($photoTmpName));
                $sql = "UPDATE userportal1 SET username='$username', fullname='$fullname', email='$email', address='$address', photo='$photoContent' WHERE Id='$id'";
            } else {
                echo "<script>alert('Your file is too large.')</script>";
                exit;
            }
        } else {
            echo "<script>alert('There was an error uploading your file.')</script>";
            exit;
        }
    } else {
        $sql = "UPDATE userportal1 SET username='$username', fullname='$fullname', email='$email', address='$address' WHERE Id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data Modified Successfully')</script>";
    } else {
        echo "<script>alert('Failed to modify data: " . mysqli_error($conn) . "')</script>";
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql_check = "SELECT * FROM userportal1 WHERE Id = '$id'";
    $data = mysqli_query($conn, $sql_check);
    $result_check = mysqli_fetch_assoc($data);
    if ($result_check) {
        $sql = "DELETE FROM userportal1 WHERE Id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Data Deleted Successfully')</script>";
        } else {
            echo "<script>alert('Failed to delete data: " . mysqli_error($conn) . "')</script>";
        }
    } else {
        echo "<script>alert('ID doesn\'t exist')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="subform" style = "height: 550px;">
        <h4 style="text-align:center;margin-top:5px;">User Management Portal</h4>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Enter ID" name="id" class="intex" required value="<?= isset($result) ? $result['Id'] : '' ?>">
            <input type="text" placeholder="Enter username" name="username" class="intex" value="<?= isset($result) ? $result['username'] : '' ?>">
            <input type="text" placeholder="Enter your full name" name="fullname" class="intex" value="<?= isset($result) ? $result['fullname'] : '' ?>">
            <input type="email" placeholder="Enter email" name="email" class="intex" value="<?= isset($result) ? $result['email'] : '' ?>">
            <input type="text" placeholder="Enter your permanent address" name="address" class="intex" style="height:50px;" value="<?= isset($result) ? $result['address'] : '' ?>">
            <label for="photo">Choose photo:</label>
            <input type="file" name="photo" id="photo" class="intex" <?= isset($_POST['submit']) || isset($_POST['modify']) ? 'required' : '' ?>>
            <?php if (isset($result) && $result['photo']): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($result['photo']) ?>" alt="User Photo" style="width:100%;height:auto;margin-top:10px;">
            <?php endif; ?>
            <button type="submit" class="btn" name="submit">Submit</button>
            <button type="submit" class="btn" name="search" style="background-color:grey;">Search</button>
            <button type="submit" class="btn" name="modify" style="background-color:yellow;color:black;">Modify</button>
            <button type="submit" class="btn" name="delete" style="background-color:red;" onclick="return confirmdelete();">Delete</button>
        </form>
    </div>
    <script>
        function confirmdelete(){
            return confirm("Are you sure to delete this data?");
        }
    </script>
</body>
</html>
