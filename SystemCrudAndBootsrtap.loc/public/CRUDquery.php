<?php

$conn = new mysqli("localhost", "root", "", "curd") OR die("Error: " . mysqli_error($conn));

session_start();
//code to save user's data
if (isset($_POST['save'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $iQuery = "INSERT INTO account(username, password) values(?, ?)";

        $stmt = $conn->prepare($iQuery);
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()){
            $_SESSION['msg'] = "New record is successfully inserted";
            $_SESSION['alert'] = "alert alert-success";
        }
        $stmt->close();
        $conn->close();
    }
    else {
        $_SESSION['msg'] = "Username and password should not be empty";
        $_SESSION['alert'] = "alert alert-warning";
    }
   header("location: index.php");
}

#Delete selected data
if(isset($_POST['delete'])){
$id = $_POST['delete'];

$dQuery = "DELETE FROM account WHERE id = ?";
$stmt = $conn->prepare($dQuery);
$stmt->bind_param('i', $id);
if($stmt->execute()){
    $_SESSION['msg'] = "Selected record is seccesfully deleted.";
    $_SESSION['alert'] = "alert alert-danger";
}
$stmt->close();
$conn->close();
header("location: index.php");
}

# Update selected user's data
if(isset($_POST['edit'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $id = $_POST['edit'];

        $uQuery = "UPDATE account SET username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($uQuery);
        $stmt->bind_param('ssi', $username, $password, $id);

        if($stmt->execute()){
            $_SESSION['msg'] = "Selected record is seccesfully Updated.";
            $_SESSION['alert'] = "alert alert-success";
        }
        $stmt->close();
        $conn->close();
    }
    else{
        $_SESSION['msg'] = "Username and password should not be empty";
        $_SESSION['alert'] = "alert alert-warning";
    }
    header("location: index.php");
}