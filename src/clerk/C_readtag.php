<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="/sapds/src/css/attendance.css" rel="stylesheet">
        <script src="/sapds/src/js/bootstrap.min.js"></script>
		<script src="jquery.min.js"></script>
		<link rel="stylesheet" href="/sapds/src/css/navigation.css">
		<script src="/sapds/src/js/navigation.js"></script>
		<script>
			$(document).ready(function(){
				 $("#getUID").load("UIDContainer.php");
				setInterval(function() {
					$("#getUID").load("UIDContainer.php");	
				}, 500);
			});
		</script>
		
		<style>
			header img {
          margin-right: 0%;
          margin-left: 5px;
        }
		</style>
	</head>
	
	<body>
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<a href="clerk_main.html">Home</a>
			<a href="C_attendance.html">Attendance</a>
			<a href="C_location.html">Location</a>
			<a href="C_schedule.html">Schedule</a>
			<a href="C_readtag.php" class="active">Read RFID Tag</a>
			<a href="C_register.php">Register</a>
			<a href="C_userdata.php">Student list</a>
		</div>

		<header>
			<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
			<img src="/sapds/src/img/logo.png" alt="Logo">
			<h1>Read RFID Tag</h1>
		</header>
		<h3 align="center" id="blink">Please Scan Tag to Display ID or Student Data</h3>
		
		<p id="getUID" hidden></p>
		
        <div id="show_user_data" align="center">
        <form>
    <table>

        <tr>
            <td>
                <table>
                <tr>
                        <td>RFID ID</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                    
                    <tr>
                        <td>Gender</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                    <tr>
                        <td>Mobile Number (If available)</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                    <tr>
                        <td>IC Number</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                    <tr>
                        <td>Class</td>
                        <td>:</td>
                        <td>--------</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
        </div>

		<script>
			var myVar = setInterval(myTimer, 1000);
			var myVar1 = setInterval(myTimer1, 1000);
			var oldID="";
			clearInterval(myVar1);

			function myTimer() {
				var getID=document.getElementById("getUID").innerHTML;
				oldID=getID;
				if(getID!="") {
					myVar1 = setInterval(myTimer1, 500);
					showUser(getID);
					clearInterval(myVar);
				}
			}
			
			function myTimer1() {
				var getID=document.getElementById("getUID").innerHTML;
				if(oldID!=getID) {
					myVar = setInterval(myTimer, 500);
					clearInterval(myVar1);
				}
			}
			
			function showUser(str) {
				if (str == "") {
					document.getElementById("show_user_data").innerHTML = "";
					return;
				} else {
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("show_user_data").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET","C_readtaguserdata.php?id="+str,true);
					xmlhttp.send();
				}
			}
			
			var blink = document.getElementById('blink');
			setInterval(function() {
				blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
			}, 750); 
		</script>
	</body>
</html>
