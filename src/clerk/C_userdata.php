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
    <link rel="stylesheet" href="/sapds/src/css/navigation.css">
    <!-- <link href="/sapds/src/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="/sapds/src/js/bootstrap.min.js"></script>
    <script src="/sapds/src/js/navigation.js"></script>


    <style>
        .container {
            padding: 16px;
        }

        header img {
          margin-right: 0%;
          margin-left: 5px;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .buttons {
            display: inline-flex;
            margin-top: 20px;
            justify-content: center;
        }

        .buttons a {
            padding: 10px 20px;
            background-color: #435c47;
            color: white;
            border-radius: 5px;
            margin-right: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #3b513e;
        }

        /* Styling for the search and filter controls */
        .search-container {
            margin-bottom: 20px;
        }

        .search-container input, .search-container select {
            padding: 8px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
        <a href="C_readtag.php">Read RFID Tag</a>
        <a href="C_register.php">Register</a>
        <a href="C_userdata.php" class="active">Student list</a>
    </div>

    <header>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <img src="/sapds/src/img/logo.png" alt="Logo">
        <h1>Student Data</h1>
    </header>

    <div class="container">
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names..">
            <select id="genderFilter" onchange="filterTable()">
                <option value="">Filter by Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <select id="classFilter" onchange="filterTable()">
                <option value="">Filter by Class</option>
                <option value="A1">Class A1</option>
                <option value="B1">Class B1</option>
            </select>
        </div>

        <div class="row">
            <h3>Student Data Table</h3>
        </div>
        <div class="row table-container">
            <table class="table table-striped table-bordered" id="studentTable">
                <thead>
                    <tr>
                        <th>RFID ID</th>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Class</th>
                        <th>Mobile Number (If available)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include '../database.php';
                        $pdo = Database::connect();
                        $sql = 'SELECT * FROM children ORDER BY name ASC';
                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['ic'] . '</td>';
                            echo '<td>'. $row['gender'] . '</td>';
                            echo '<td>'. $row['age'] . '</td>';
                            echo '<td>'. $row['class'] . '</td>';
                            echo '<td>'. $row['mobile'] . '</td>';
                            echo '<td><a class="edit-button" href="C_editpage.php?id='.$row['id'].'">Edit</a>';
                            echo ' ';
                            echo '<a class="delete-button" href="C_deletepage.php?id='.$row['id'].'">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- /container -->

    <script>
        // Search function
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            table = document.getElementById('studentTable');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td')[1]; // search by name (first column)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Filter function for Gender and Class
        function filterTable() {
            var genderFilter, classFilter, table, tr, td, i, gender, classValue;
            genderFilter = document.getElementById('genderFilter').value.toUpperCase();
            classFilter = document.getElementById('classFilter').value.toUpperCase();
            table = document.getElementById('studentTable');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td');
                if (td) {
                    gender = td[3].textContent || td[3].innerText; // Gender column
                    classValue = td[5].textContent || td[5].innerText; // Class column
                    if ((gender.toUpperCase().indexOf(genderFilter) > -1 || genderFilter === '') && 
                        (classValue.toUpperCase().indexOf(classFilter) > -1 || classFilter === '')) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>
</html>
