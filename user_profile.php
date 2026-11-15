<?php
session_start();
$uid = $_SESSION['uid'];
if (!$uid) {
?>
<script>
alert("Please Login");
location.href="userlogin.php";
</script>
<?php
}
else
 {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile - BookHouse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8ECAE6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .profile-info {
            margin: 15px 0;
            text-align: left;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-logout {
            background-color: #dc3545;
        }
        .btn-logout:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <div class="profile-info">
            <?php
            include("db.php");
            $query = mysqli_query($conn, "SELECT * FROM user WHERE u_id='$uid'");
            while ($row = mysqli_fetch_row($query)) {
            ?>
            <p><strong>Name:</strong> <span id="name"><?php echo $row[1]; ?></span></p>
            <p><strong>Address:</strong> <span id="adress"><?php echo $row[2]; ?></span></p>
            <p><strong>Phone:</strong> <span id="ph_no"><?php echo $row[3]; ?></span></p>
            <p><strong>Email:</strong> <span id="email"><?php echo $row[4]; ?></span></p>
            <p><strong>Password:</strong> <span id="password"><?php echo $row[5]; ?></span></p>
            <a href="user_profile_edit.php"><button class="btn">Edit Profile</button></a>
            <a href="bookdashboard.php"><button class="btn">Back</button></a>
            <a href="logout.php"><button class="btn btn-logout">Logout</button></a> 
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php
}
?>
