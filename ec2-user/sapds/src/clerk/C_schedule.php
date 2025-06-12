<?php
// Check if the class parameter exists in the URL
$class = isset($_GET['class']) ? htmlspecialchars($_GET['class']) : 'A1'; // Default class is 'A1'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule</title>
    <link rel="stylesheet" href="/sapds/src/css/attendance.css">
    <link rel="stylesheet" href="/sapds/src/css/navigation.css">
    <script src="/sapds/src/js/navigation.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("class").addEventListener("change", function () {
                const selectedClass = this.value;
                window.location.href = "C_schedule.php?class=" + selectedClass;
            });
        });
    </script>
</head>
<body>
    <header>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <img src="/sapds/src/img/logo.png" alt="Logo">
        <h1>Class Schedule</h1>
    </header>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="clerk_main.html">Home</a>
        <a href="C_attendance.php">Attendance</a>
        <a href="C_location.php">Location</a>
        <a href="C_schedule.php">Schedule</a>
        <a href="C_readtag.php">Read RFID Tag</a>
        <a href="C_register.php">Register</a>
        <a href="C_userdata.php">Student List</a>
    </div>

    <div class="info">
        <label for="class">Select Class:</label>
        <select id="class" name="class">
            <option value="">--Choose--</option>
            <option value="A1" <?= $class == 'A1' ? 'selected' : '' ?>>A1</option>
            <option value="B1" <?= $class == 'B1' ? 'selected' : '' ?>>B1</option>
        </select>
    </div>

    <div class="info">
      <div class="table-container">
          <h2>Class Schedule for <?= $class ?></h2>

          <form method="post" action="timetable.php">
              <input type="hidden" name="selectedClass" value="<?= $class ?>">

              <table>
                  <thead>
                      <tr>
                          <th>Time</th>
                          <th>Mon</th>
                          <th>Tue</th>
                          <th>Wed</th>
                          <th>Thu</th>
                          <th>Fri</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>08:00-09:00</td>
                          <td><input type="text" name="schedule[08:00-09:00][Mon]" value=""></td>
                          <td><input type="text" name="schedule[08:00-09:00][Tue]" value=""></td>
                          <td><input type="text" name="schedule[08:00-09:00][Wed]" value=""></td>
                          <td><input type="text" name="schedule[08:00-09:00][Thu]" value=""></td>
                          <td><input type="text" name="schedule[08:00-09:00][Fri]" value=""></td>
                      </tr>
                      <!-- Repeat for other time slots -->
                  </tbody>
              </table>

              <br>
              <button type="submit">Save Timetable</button>
          </form>
      </div>
    </div>
</body>
</html>
