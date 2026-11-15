<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: userlogin.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "book_house");

$user_id = (int) $_SESSION['uid'];
$rent_id = (int) $_GET['rent_id'];

// Only cancel an unpaid (pending) rent that belongs to this user
mysqli_query($conn, "UPDATE rent SET status = 'cancelled' WHERE rent_id = '$rent_id' AND u_id = '$user_id' AND status = 'pending'");
?>
<script>
    alert("Rent cancelled.");
    location.href = "my_orders.php";
</script>