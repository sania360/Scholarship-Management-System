<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "scholarship_system");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Insert data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $cnic = $_POST['cnic'];
    $level = $_POST['level'];
    $institute = $_POST['institute'];
    $percentage = $_POST['percentage'];
    $year = $_POST['year'];

    $sql = "INSERT INTO students 
    (name, email, cnic, level, institute, percentage, completion_year)
    VALUES 
    ('$name', '$email', '$cnic', '$level', '$institute', '$percentage', '$year')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>✅ Student data saved successfully</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>

<h2>Student Basic Information</h2>

<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    CNIC: <input type="text" name="cnic" required><br><br>

    <h3>Education Details</h3>

    Level:
    <select name="level">
        <option>Matric</option>
        <option>Intermediate</option>
        <option>Bachelor</option>
        <option>Master</option>
    </select><br><br>

    Institute: <input type="text" name="institute"><br><br>
    Percentage: <input type="number" step="0.01" name="percentage"><br><br>
    Completion Year: <input type="number" name="year"><br><br>

    <input type="submit" value="Save Profile">
</form>

</body>
</html>
