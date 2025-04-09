<?php
    require '../database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM children where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    
    $msg = null;
    if ($data === false) {
        // If no record was found for the given ID
        $msg = "The ID of your Card / KeyChain is not registered !!!\nPlease register your RFID at Register page";
        // Set default values for the fields
        $data = [
            'id' => $id,
            'name' => '--------',
            'gender' => '--------',
            'ic' => '--------',
            'age' => '--------',
            'class' => '--------',
            'mobile' => '--------',
        ];
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/sapds/src/css/attendance.css" rel="stylesheet">
    <script src="/sapds/src/js/bootstrap.min.js"></script>
</head>
 
<body>    
    <div>
        <form>
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>ID</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['id']); ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['name']); ?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['gender']); ?></td>
                            </tr>
                            <tr>
                                <td>Mobile Number (If available)</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['mobile']); ?></td>
                            </tr>
                            <tr>
                                <td>IC Number</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['ic']); ?></td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['age']); ?></td>
                            </tr>
                            <tr>
                                <td>Class</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($data['class']); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <p style="color:red;"><?php echo htmlspecialchars($msg); ?></p>
</body>
</html>
