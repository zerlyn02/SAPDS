<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
        <link rel="stylesheet" href="/sapds/src/css/attendance.css">
		<script src="/sapds/src/js/bootstrap.min.js"></script>
		<script src="jquery.min.js"></script>
		<script src="/sapds/src/js/navigation.js"></script>
		<link rel="stylesheet" href="/sapds/src/css/navigation.css">
		<link rel="stylesheet" href="/sapds/src/css/modal.css">

		<script>
			function toggleForm(userType) {
				console.log('Toggling form for:', userType);
				// Hide both forms initially
				document.getElementById('studentForm').style.display = 'none';
				document.getElementById('userForm').style.display = 'none';

				// Show the selected form
				if (userType === 'student') {
					console.log('Toggling form for:', userType);
					document.getElementById('studentForm').style.display = 'block';
				} else if (userType === 'user') {
					console.log('Toggling form for:', userType);
					document.getElementById('userForm').style.display = 'block';
				}
			}

			async function submitForm() {
			const formData = {
				name: document.getElementById('userName').value,
				email: document.getElementById('userEmail').value,
				username: document.getElementById('userUsername').value,
				password: document.getElementById('userPassword').value,
				phone: document.getElementById('userPhone').value,
				address: document.getElementById('userAddress').value,
				role: document.querySelector('input[name="role"]:checked')?.value || '',
				adminRole: document.getElementById('adminRole')?.value || null,
				childName: document.getElementById('childName')?.value || null,
				relationship: document.getElementById('relationship')?.value || null,
				carPlate: document.getElementById('carPlate')?.value || null,
			};


            try {
                const response = await fetch('../register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                if (response.ok) {
                    const modal = document.getElementById('successModal');
                    modal.style.display = 'flex';
                } else {
                    alert('Registration failed. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            }
        }

			$(document).ready(function() {
				$("#getUID").load("UIDContainer.php");
				setInterval(function () {
					$("#getUID").load("UIDContainer.php");
				}, 500);

				const adminRadio = document.getElementById('admin');
				const guardianRadio = document.getElementById('guardian');
				const adminOptions = document.getElementById('adminOptions');
				const guardianOptions = document.getElementById('guardianOptions');

				if (adminRadio && guardianRadio) {
					adminRadio.addEventListener('change', () => {
						adminOptions.style.display = 'block';
						guardianOptions.style.display = 'none';
					});

					guardianRadio.addEventListener('change', () => {
						guardianOptions.style.display = 'block';
						adminOptions.style.display = 'none';
					});
				}
			});
		</script>

		
		<style>
		header img {
          margin-right: 0%;
          margin-left: 5px;
        }

		.role-options {
            margin-top: 10px;
        }

        .role-specific {
            display: none;
            margin-top: 10px;
        }
		</style>

	</head>
	
	<body>

    <header>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <img src="/sapds/src/img/logo.png" alt="Logo">
        <h1>Register</h1>
    </header>
	<div class="info">
        <div class="editContainer">
        <h3>Select Type</h3>
        <form id="editForm">
            <div>
                <label>
                    <input type="radio" name="userType" value="student" id="studentRadio" onclick="toggleForm('student')"> Student
                </label>
                <label>
                    <input type="radio" name="userType" value="user" id="userRadio" onclick="toggleForm('user')"> User
                </label>
            </div>
		</form>

		<div id="studentForm" class="container" style="margin: 5px auto; max-width: 600px; padding-top: 20px; margin-bottom: 30px; display: none;">
			<div>
				<form action="insertDB.php" method="post" >
					<div>
						<label>RFID ID</label>
						<div>
							<textarea name="id" id="getUID" placeholder="Please Scan your Card / Key Chain to display ID" rows="2" cols="30" required></textarea>
						</div>
					</div>
					<br>
					
					<div>
						<label>Student IC Number</label>
						<div>
							<input id="studentIc" name="ic" type="text"  maxlength="12" placeholder="12-digit IC number" required>
						</div>
					</div>
                    
					<div>
						<label>Student Name</label>
						<div>
							<input id="div_refresh" name="name" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div>
						<label>Student Gender</label>
						<div>
							<select name="gender">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>
					</div>

					<div>
						<label>Student Age</label>
						<div>
							<input name="age" type="number" id="studentAge" placeholder="Age" required>
						</div>
					</div>

					<div>
						<label>Class</label>
						<div>
							<select name="class">
							<option value="1Alpha">1Alpha</option>
							<option value="1Bestari">1Bestari</option>
							</select>
						</div>
					</div>
					
					<div>
						<label>Mobile Number (If available)</label>
						<div>
							<input name="mobile" type="text"  placeholder="">
						</div>
					</div>
					
					<div>
						<button type="submit" class="btn btn-success">Save</button>
                    </div>
				</form>
			</div>
		</div>               

	<!-- User -->
	<div id="userForm" style="display: none; padding-top: 20px;">
		<form onsubmit="submitForm(event)">
                <label for="userName">Name:</label> <br>
                <input type="text" id="userName" name="userName" placeholder="Full Name" required> <br>

                <label for="userEmail">Email:</label> <br>
                <input type="email" id="userEmail" name="userEmail" placeholder="Email Address" required> <br>

                <label for="userUsername">Username:</label> <br>
                <input type="text" id="userUsername" name="userUsername" placeholder="Username" required> <br>

                <label for="userPassword">Password:</label> <br>
                <input type="password" id="userPassword" name="userPassword" placeholder="Password" required> <br>

                <label for="userPhone">Phone Number:</label> <br>
                <input type="tel" id="userPhone" name="userPhone" placeholder="Phone Number" required> <br>

                <label for="userAddress">Address:</label> <br>
                <input type="text" id="userAddress" name="userAddress" placeholder="Address" required></textarea> <br>

                <label>Role:</label>
            <div class="role-options">
                <input type="radio" id="admin" name="role" value="school-administrator" required>
                <label for="admin">School Administrator</label>

                <input type="radio" id="guardian" name="role" value="guardian" required>
                <label for="guardian">Guardian</label>
            </div>

            <div id="adminOptions" class="role-specific">
                <label for="adminRole">Administrator Role:</label>
                <select id="adminRole" name="adminRole">
                    <option value="clerk">Clerk</option>
                    <option value="teacher">Teacher</option>
                    <option value="operator">School Operator</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div id="guardianOptions" class="role-specific">
                <label for="childName">Child Name:</label>
                <input type="text" id="childName" name="childName" placeholder="Child Name">

                <label for="relationship">Relationship:</label>
                <select id="relationship" name="relationship">
                    <option value="parent">Parent</option>
                    <option value="guardian">Guardian</option>
                </select>
                <br>
                <label for="carPlate">Car Plate:</label>
                <input type="text" id="carPlate" name="carPlate" placeholder="Car Plate">
            </div>
			<div>
				<button type="submit" class="btn btn-success">Save</button>
            </div>
		</form>
	</div> <!-- /container -->	
	

		<div class="modal" id="successModal">
			<div class="modal-content">
				<p>Registration successful!</p>
				<button onclick="window.location.href='C_register.php'">Back</button>
			</div>
		</div>

		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<a href="clerk_main.html">Home</a>
			<a href="C_attendance.html">Attendance</a>
			<a href="C_location.html">Location</a>
			<a href="timetable.php">Schedule</a>
			<a href="C_readtag.php">Read RFID Tag</a>
			<a href="C_register.php" class="active">Register</a>
			<a href="C_userdata.php">Student list</a>
		</div>

	</body>
</html>