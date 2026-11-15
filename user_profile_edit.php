<?php
session_start();
$uid=$_SESSION['uid'];
if(!$uid)
{
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
<?php
include("db.php");
$uid=$_SESSION['uid'];

$uid = $_SESSION['uid']; 
$sql = "SELECT * FROM user WHERE u_id = $uid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "user not found!";
    exit();
}
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $adress = $_POST['adress'];
    $ph_no = $_POST['ph_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_sql = "UPDATE user SET 
                    name='$name', 
                    adress='$adress', 
                    ph_no='$ph_no', 
                    email='$email', 
                    password='$password'
                    WHERE u_id = $uid";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script> window.location.href='user_profile.php';</script>";
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user Profile - bookhouse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8ECAE6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }
        .form-input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn:hover {
            background: #0056b3;
        }

    .label {
        display: block; 
        text-align: left;
        margin-bottom: 5px; 
    }
    
    .form-input {
        width: 100%; 
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }                                 

    </style>
</head>
<body>

<div class="container">
    <h2>user Profile</h2>
    <form method="POST">
    <label for="name" class="label">User Name:</label>
        <input type="text" name="name" class="form-input" value="<?php echo $row['name']; ?>" required>
        <label for="adress" class="label">Adress:</label>
        <input type="text" name="adress" class="form-input" value="<?php echo $row['adress']; ?>" required>
        <label for="phone_no" class="label">Phone Number:</label>
        <input type="text" name="ph_no" class="form-input" value="<?php echo $row['ph_no']; ?>" maxlength="10" required>
        <label for="email_id" class="label">Email ID:</label>
        <input type="email" name="email" class="form-input" value="<?php echo $row['email']; ?>" required>
        <label for="password" class="label">password:</label>
        <input type="text" name="password" class="form-input" value="<?php echo $row['password']; ?>" required>
        <button type="submit" name="update" class="btn">Update Profile</button><hr>
        <a href="user_profile.php" class="btn">Cancel</a>
     </form>
</div>

</body>
</html>
<?php
}
?>