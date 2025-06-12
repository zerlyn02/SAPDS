<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include your database connection
require_once __DIR__ . '/../database.php';

$pdo = Database::connect();

$class = isset($_GET['class']) ? $_GET['class'] : '1Alpha'; // Default class is 'A1'

// Fetch all teachers
$teacherStmt = $pdo->prepare("SELECT name FROM users WHERE admin_role = 'teacher'");
$teacherStmt->execute();
$teachers = $teacherStmt->fetchAll(PDO::FETCH_COLUMN); // array of names

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule = $_POST['schedule'];
    $teachersData = $_POST['teachers'];

    $conflicts = [];

    foreach ($schedule as $timeSlot => $days) {
        foreach ($days as $day => $subject) {
            $teacher = $teachersData[$timeSlot][$day];

            // Skip if teacher is empty
            if (empty($teacher)) continue;

            // Check if teacher is already assigned at the same timeslot and day for this or any class
            $checkStmt = $pdo->prepare("SELECT class FROM timetable WHERE day = ? AND timeslot = ? AND teacher = ? AND class != ?");
            $checkStmt->execute([$day, $timeSlot, $teacher, $class]);
            $conflictClasses = $checkStmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($conflictClasses as $conflictClass) {
                $conflicts[] = "Conflict: $teacher is already assigned on $day at $timeSlot in class $conflictClass.";
            }
        }
    }

    if (empty($conflicts)) {
        // No conflicts, proceed with saving
        foreach ($schedule as $timeSlot => $days) {
            foreach ($days as $day => $subject) {
                $teacher = $teachersData[$timeSlot][$day];
                $stmt = $pdo->prepare("INSERT INTO timetable (class, day, timeslot, subject, teacher) 
                    VALUES (?, ?, ?, ?, ?) 
                    ON DUPLICATE KEY UPDATE subject = ?, teacher = ?");
                $stmt->execute([$class, $day, $timeSlot, $subject, $teacher, $subject, $teacher]);
            }
        }
        echo "<script>var successMessage = 'Timetable saved successfully!';</script>";
    } else {
        // Show conflicts
        echo "<script>var conflictMessages = " . json_encode(array_values($conflicts)) . ";</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Class Schedule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/sapds/src/css/attendance.css" />
    <link rel="stylesheet" href="/sapds/src/css/navigation.css" />
    <link rel="stylesheet" href="/sapds/src/css/modal.css" />
    <script src="/sapds/src/js/navigation.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("class").addEventListener("change", function () {
                const selectedClass = this.value;
                window.location.href = "timetable.php?class=" + selectedClass;
            });
        });
    </script>
</head>
<body>
    <header>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <img src="/sapds/src/img/logo.png" alt="Logo" />
        <h1>Class Schedule</h1>
    </header>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="clerk_main.html">Home</a>
        <a href="C_attendance.html">Attendance</a>
        <a href="C_location.html">Location</a>
        <a href="timetable.php">Schedule</a>
        <a href="C_readtag.php">Read RFID Tag</a>
        <a href="C_register.php">Register</a>
        <a href="C_userdata.php">Student List</a>
    </div>

    <div class="info">
        <label for="class">Select Class:</label>
        <select id="class" name="class">
            <option value="">--Choose--</option>
            <option value="1Alpha" <?= $class === '1Alpha' ? 'selected' : '' ?>>1Alpha</option>
            <option value="1Bestari" <?= $class === '1Bestari' ? 'selected' : '' ?>>1Bestari</option>
        </select>
    </div>

    <div class="info">
        <h2>Class Schedule for <?= htmlspecialchars($class) ?></h2>
        <div class="table-container">
            <form method="post" action="timetable.php?class=<?= htmlspecialchars($class) ?>">
                <input type="hidden" name="selectedClass" value="<?= htmlspecialchars($class) ?>" />

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
                        <?php
                        // Query the timetable for the selected class
                        $stmt = $pdo->prepare("SELECT * FROM timetable WHERE class = ?");
                        $stmt->execute([$class]);
                        $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Prepare timetable slots
                        $scheduleData = [];
                        foreach ($timetable as $row) {
                            $scheduleData[$row['timeslot']][$row['day']] = [
                                'subject' => $row['subject'],
                                'teacher' => $row['teacher']
                            ];
                        }

                        // Time slots and days
                        $timeslots = ['08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00'];
                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

                        foreach ($timeslots as $timeslot) {
                            echo "<tr>";
                            echo "<td>$timeslot</td>";
                            foreach ($days as $day) {
                                $subject = isset($scheduleData[$timeslot][$day]['subject']) ? $scheduleData[$timeslot][$day]['subject'] : '';
                                $teacherSelected = isset($scheduleData[$timeslot][$day]['teacher']) ? $scheduleData[$timeslot][$day]['teacher'] : '';

                                echo "<td>";
                                echo "<input type='text' name='schedule[$timeslot][$day]' value='" . htmlspecialchars($subject) . "' placeholder='Subject'><br>";
                                echo "<select name='teachers[$timeslot][$day]'>";
                                echo "<option value=''>--Select Teacher--</option>";
                                foreach ($teachers as $teacher) {
                                    $selected = $teacher === $teacherSelected ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($teacher) . "' $selected>" . htmlspecialchars($teacher) . "</option>";
                                }
                                echo "</select>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <br />
                <button type="submit">Save Timetable</button>
            </form>
        </div>
    </div>

    <!-- Modal for conflicts / success -->
    <div id="conflictModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span id="closeModal" style="float:right; cursor:pointer;">&times;</span>
            <h3 id="modalTitle">Message</h3>
            <ul id="conflictMessages"></ul>
            <p id="successMessage" style="color:green; display:none;"></p>
            <button class="modal-content button" onclick="document.getElementById('conflictModal').style.display='none'">Close</button>
        </div>
    </div>

    <script>
        function showModal(title, messages = [], successMsg = '') {
            const modal = document.getElementById('conflictModal');
            const titleEl = document.getElementById('modalTitle');
            const conflictList = document.getElementById('conflictMessages');
            const successEl = document.getElementById('successMessage');

            titleEl.textContent = title;

            if (messages.length > 0) {
                conflictList.style.display = 'block';
                successEl.style.display = 'none';
                conflictList.innerHTML = '';
                messages.forEach(msg => {
                    const li = document.createElement('li');
                    li.textContent = msg;
                    conflictList.appendChild(li);
                });
            } else if (successMsg) {
                conflictList.style.display = 'none';
                successEl.style.display = 'block';
                successEl.textContent = successMsg;
            }

            modal.style.display = 'block';

            document.getElementById('closeModal').onclick = () => {
                modal.style.display = 'none';
            };
        }

        // Close modal when clicking outside
        window.onclick = (event) => {
            const modal = document.getElementById('conflictModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        // On page load, check if PHP set JS variables and show modal accordingly
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof conflictMessages !== 'undefined' && conflictMessages.length > 0) {
                showModal('Conflict Detected', conflictMessages);
            } else if (typeof successMessage !== 'undefined' && successMessage.length > 0) {
                showModal('Success', [], successMessage);
            }
        });
    </script>
</body>
</html>
