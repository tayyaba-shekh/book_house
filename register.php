<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            background: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        p {
            text-align: center;
            margin-top: 15px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="userreg.php" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Full Name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="ph_no">Phone Number</label>
            <input type="text" maxlength="10" minlength="10" id="ph_no" name="ph_no" placeholder="Phone Number" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Address" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

            <input type="submit" name="submit" value="Register">
        </form>
        <p>Already have an account? <a href="userlogin.php">Login here</a></p>
    </div>
</body>
</html>
