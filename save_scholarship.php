<?php
$conn = mysqli_connect("localhost","root","","scholarship_system");
if(!$conn){
    die("DB Connection Failed");
}

/* ---------------- STUDENT INSERT ---------------- */
if(isset($_POST['save_student'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cnic = $_POST['cnic'];
    $level = $_POST['level'];
    $institute = $_POST['institute'];
    $percentage = $_POST['percentage'];
    $year = $_POST['year'];

    $q1 = mysqli_query($conn,"INSERT INTO students(name,email,cnic)
                              VALUES('$name','$email','$cnic')");

    if($q1){
        $sid = mysqli_insert_id($conn);
        mysqli_query($conn,"INSERT INTO education(student_id,level,institute,percentage,completion_year)
                            VALUES('$sid','$level','$institute','$percentage','$year')");
        $msg = "Student saved successfully";
    }
}

/* ---------------- SCHOLARSHIP INSERT ---------------- */
if(isset($_POST['add_scholarship'])){
    mysqli_query($conn,"INSERT INTO scholarships
    (scholarship_name,institute,benefits,degree_level,min_percentage,country)
    VALUES(
        '$_POST[sname]',
        '$_POST[sinstitute]',
        '$_POST[benefits]',
        '$_POST[degree]',
        '$_POST[min_percentage]',
        '$_POST[country]'
    )");
    $msg = "Scholarship added successfully";
}

/* ---------------- SCHOLARSHIP DELETE ---------------- */
if(isset($_GET['del'])){
    mysqli_query($conn,"DELETE FROM scholarships WHERE scholarship_id='$_GET[del]'");
    header("Location: system.php");
    exit();
}

/* ---------------- SCHOLARSHIP UPDATE ---------------- */
if(isset($_POST['update_scholarship'])){
    mysqli_query($conn,"UPDATE scholarships SET
        scholarship_name='$_POST[sname]',
        institute='$_POST[sinstitute]',
        benefits='$_POST[benefits]',
        degree_level='$_POST[degree]',
        min_percentage='$_POST[min_percentage]',
        country='$_POST[country]'
        WHERE scholarship_id='$_POST[id]'");
    header("Location: system.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student & Scholarship System</title>
<style>
body{font-family:Arial;background:#f2f2f2}
form,table{background:#fff;padding:20px;margin:20px auto;width:500px;border-radius:10px}
input,select,textarea{width:100%;padding:8px;margin-bottom:10px}
button{background:#007bff;color:white;padding:10px;border:none;width:100%}
table{width:90%}
th{background:#007bff;color:white}
td,th{text-align:center;padding:8px}
a{color:red;text-decoration:none}
.success{color:green;text-align:center}
</style>
</head>

<body>

<h2 align="center">Student & Scholarship System</h2>
<?php if(isset($msg)) echo "<p class='success'>$msg</p>"; ?>

<!-- ================= STUDENT FORM ================= -->
<form method="post">
<h3>Student Registration</h3>
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="cnic" placeholder="CNIC" required>

<select name="level">
<option>Matric</option>
<option>Intermediate</option>
<option>Bachelor</option>
<option>Master</option>
</select>

<input type="text" name="institute" placeholder="Institute">
<input type="number" step="0.01" name="percentage" placeholder="Percentage">
<input type="number" name="year" placeholder="Completion Year">

<button name="save_student">Save Student</button>
</form>

<!-- ================= SCHOLARSHIP FORM ================= -->
<form method="post">
<h3>Add Scholarship</h3>
<input type="text" name="sname" placeholder="Scholarship Name" required>
<input type="text" name="sinstitute" placeholder="Institute" required>
<textarea name="benefits" placeholder="Benefits"></textarea>

<select name="degree">
<option>Bachelor</option>
<option>Master</option>
<option>PhD</option>
</select>

<input type="number" step="0.01" name="min_percentage" placeholder="Min Percentage">
<input type="text" name="country" placeholder="Country">

<button name="add_scholarship">Add Scholarship</button>
</form>

<!-- ================= SCHOLARSHIP TABLE ================= -->
<table border="1">
<tr>
<th>ID</th><th>Name</th><th>Institute</th><th>Degree</th><th>Min%</th><th>Country</th><th>Action</th>
</tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM scholarships");
while($r=mysqli_fetch_assoc($res)){
echo "<tr>
<td>$r[scholarship_id]</td>
<td>$r[scholarship_name]</td>
<td>$r[institute]</td>
<td>$r[degree_level]</td>
<td>$r[min_percentage]</td>
<td>$r[country]</td>
<td>
<a href='?edit=$r[scholarship_id]'>Edit</a> |
<a href='?del=$r[scholarship_id]' onclick='return confirm(\"Delete?\")'>Delete</a>
</td>
</tr>";
}
?>
</table>

<!-- ================= EDIT FORM ================= -->
<?php
if(isset($_GET['edit'])){
$e = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM scholarships WHERE scholarship_id='$_GET[edit]'"));
?>
<form method="post">
<h3>Edit Scholarship</h3>
<input type="hidden" name="id" value="<?= $e['scholarship_id'] ?>">
<input type="text" name="sname" value="<?= $e['scholarship_name'] ?>">
<input type="text" name="sinstitute" value="<?= $e['institute'] ?>">
<textarea name="benefits"><?= $e['benefits'] ?></textarea>

<select name="degree">
<option <?=($e['degree_level']=="Bachelor")?"selected":""?>>Bachelor</option>
<option <?=($e['degree_level']=="Master")?"selected":""?>>Master</option>
<option <?=($e['degree_level']=="PhD")?"selected":""?>>PhD</option>
</select>

<input type="number" step="0.01" name="min_percentage" value="<?= $e['min_percentage'] ?>">
<input type="text" name="country" value="<?= $e['country'] ?>">

<button name="update_scholarship">Update</button>
</form>
<?php } ?>

</body>
</html>
