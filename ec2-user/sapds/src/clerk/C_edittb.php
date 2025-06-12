<?php
    require '../database.php';

    if (!empty($_POST)) {
        // Capture all form values safely
        $id = $_POST['id'];
        $ic = $_POST['ic'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $class = $_POST['class'];
        $mobile = $_POST['mobile'];

        // Connect to database
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare UPDATE query
        $sql = "UPDATE children 
                SET ic = ?, name = ?, gender = ?, age = ?, class = ?, mobile = ?
                WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($ic, $name, $gender, $age, $class, $mobile, $id));

        Database::disconnect();

        // After update, redirect to user data page
        header("Location: C_userdata.php");
        exit();
    } else {
        // If accessed without form submit, redirect back
        header("Location: C_userdata.php");
        exit();
    }
?>
