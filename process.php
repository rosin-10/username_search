<?php
// Database connection
$user = 'root';
$pass = '';
$host = 'localhost';
$db = 'external';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    echo '<h2>Database connected</h2>';
}

// Handle user registration
if (isset($_POST['register'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    // Check if the username already exists
    $check = "SELECT * FROM login WHERE name='$name'";
    $cresult = $conn->query($check);
    if ($cresult->num_rows > 0) {
        echo 'Username already exists';
    } else {
        // Insert new user
        $insert = "INSERT INTO login (id, name, password, gender, dob) VALUES ($id, '$name', '$password', '$gender', '$dob')";
        if ($conn->query($insert)) {
            echo 'User entered successfully';
        } else {
            echo $conn->error;
        }
    }
}

// Handle user login
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    
    $lcheck = "SELECT name, password FROM login WHERE name='$user'";
    $lres = $conn->query($lcheck);
    
    if ($lres->num_rows == 1) {
        $row = $lres->fetch_assoc();
        if ($row['password'] == $pass) {
            echo "<script>alert('Login successful')</script>";
        } else {
            echo "<script>alert('Incorrect password')</script>";
        }
    } else {
        echo "<script>alert('Invalid username')</script>";
    }
}

// Handle user search
if (isset($_POST['search'])) {
    $suser = $_POST['suser'];
    $res = $conn->query("SELECT id, name, gender, dob FROM login WHERE name='$suser'");
    
    if ($res->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                </tr>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['gender'] . "</td>
                    <td>" . $row['dob'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo 'No results found';
    }
}

$conn->close();
?>
