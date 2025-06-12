<?php
     
    require '../database.php';
 
    if ( !empty($_POST)) {
        // keep track post values
        $name = $_POST['name'];
		$id = $_POST['id'];
		$gender = $_POST['gender'];
        $mobile = $_POST['mobile'];
        $ic = $_POST['ic'];
        $age = $_POST['age'];
        $class = $_POST['class'];
        
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO children (name,id,gender,mobile,ic,age,class) values(?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$id,$gender,$mobile,$ic,$age,$class));
		Database::disconnect();
		header("Location: C_userdata.php");
    }
?>