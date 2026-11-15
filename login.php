<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "book_house");

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT a_id FROM admin WHERE email = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$admin = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($admin) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['a_id'];
    ?>
    <script>
        alert("welcome admin");
        location.href = "dashboard.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("login failed try again");
        location.href = "house.html";
    </script>
    <?php
}
?>