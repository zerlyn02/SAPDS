<?php
    require '../database.php';

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $id = $_GET['id'];
        $ic = $_POST['ic'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $class = $_POST['class'];
        $mobile = $_POST['mobile'];

        // Connect to the database
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the record
        $sql = "UPDATE children SET ic = ?, name = ?, gender = ?, age = ?, class = ?, mobile = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($ic, $name, $gender, $age, $class, $mobile, $id));

        // Redirect after updating
        Database::disconnect();
        header("Location: C_userdata.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
        <link rel="stylesheet" href="/sapds/src/css/attendance.css">
		<!-- <script src="/sapds/src/js/bootstrap.min.js"></script> -->
		
	</head>
	
	<body>

        <header>
            <img src="/sapds/src/img/logo.png" alt="Logo">
            <h1>Edit Children Data</h1>
        </header>

        <div class="container">
        
            <div>
                <div class="row">
                    <h3 align="center">Edit User Data</h3>
                    <p id="defaultGender" hidden><?php echo $data['gender'];?></p>
                </div>
        
                <form action="C_edittb.php?id=<?php echo $id?>" method="post">
                    <div>
                        <label>RFID ID</label>
                        <div>
                            <input name="id" type="text"  placeholder="" value="<?php echo $data['id'];?>" readonly>
                        </div>
                    </div>
                    
                    <div>
                        <label>Student IC Number</label>
                        <div>
                            <input name="ic" type="text"  placeholder="" value="<?php echo $data['ic'];?>" required>
                        </div>
                    </div>

                    <div>
                        <label>Student Name</label>
                        <div>
                            <input name="name" type="text"  placeholder="" value="<?php echo $data['name'];?>" required>
                        </div>
                    </div>
                    
                    <div>
                        <label>Student Gender</label>
                        <div>
                            <select name="gender" id="mySelect">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label>Student Age</label>
                        <div>
                            <input name="age" type="text"  placeholder="" value="<?php echo $data['age'];?>" required>
                        </div>
                    </div>

                    <div>
                        <label>Class</label>
                        <div>
                            <input name="class" type="text"  placeholder="" value="<?php echo $data['class'];?>" required>
                        </div>
                    </div>

                    <div>
                        <label>Mobile Number (If available)</label>
                        <div>
                            <input name="mobile" type="text"  placeholder="" value="<?php echo $data['mobile'];?>">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button class="btn" type="button" onclick="window.location.href='C_userdata.php';">Back</button>
                    </div>
                </form>
            </div>               
        </div> <!-- /container -->	
		
		<script>
			var g = document.getElementById("defaultGender").innerHTML;
			if(g=="Male") {
				document.getElementById("mySelect").selectedIndex = "0";
			} else {
				document.getElementById("mySelect").selectedIndex = "1";
			}
		</script>
	</body>
</html>