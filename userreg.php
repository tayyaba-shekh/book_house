<?php
$conn = mysqli_connect("localhost", "root", "", "book_house");

$name             = trim($_POST['name']);
$email            = trim($_POST['email']);
$ph_no            = trim($_POST['ph_no']);
$address          = trim($_POST['address']);
$password         = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$pic              = "uploads/avatar.png";

// Passwords must match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match'); location.href='register.php';</script>";
    exit();
}

// Email must not be registered already
$check = mysqli_prepare($conn, "SELECT u_id FROM user WHERE email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
if (mysqli_num_rows(mysqli_stmt_get_result($check)) > 0) {
    echo "<script>alert('This email is already registered'); location.href='register.php';</script>";
    exit();
}

// Save the new user
$stmt = mysqli_prepare($conn, "INSERT INTO user (name, adress, ph_no, email, password, status, profile_picture) VALUES (?, ?, ?, ?, ?, 'approve', ?)");
mysqli_stmt_bind_param($stmt, "ssssss", $name, $address, $ph_no, $email, $password, $pic);
$ok = mysqli_stmt_execute($stmt);
?>
<script>
<?php if ($ok) { ?>
    alert("user register sucess");
    location.href = "userlogin.php";
<?php } else { ?>
    alert("user not register");
    location.href = "register.php";
<?php } ?>
</script>