<?php
    require '../database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM children  WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: C_userdata.php");
         
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/sapds/src/css/attendance.css">
    <script src="/sapds/src/js/bootstrap.min.js"></script>

    <style>
    .container {
        margin: 100px auto;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        background-color: #fff;
        border-radius: 10px;
        text-align: center;
    }

    .btn {
        width: 60px;
    }

    .btn-cancel {
        background-color: white;
        color: black;
        border: 1px solid #ccc;
        padding: 6px 12px;
        border-radius: 4px;
    }
</style>

</head>
 
<body>

    <div class="container">
     
		<!-- <div class="span10 offset1">
			<div class="row">
				<h3 align="center">Delete User</h3>
			</div> -->

			<form class="form-horizontal" action="C_deletepage.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure to delete ?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-cancel">Yes</button>
                    <button class="btn" type="button" onclick="window.location.href='C_userdata.php';">No</button>
                    </div>
			</form>
		</div>
                 
    </div> <!-- /container -->
  </body>
</html>