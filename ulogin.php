<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "book_house");

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Look for a user with this email and password (prepared statement = safe from SQL injection)
$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$sql = mysqli_stmt_get_result($stmt);
$row = mysqli_num_rows($sql);
$r   = mysqli_fetch_array($sql);

if ($row > 0 && $r['status'] != 'disapprove') {

    // Login success
    session_regenerate_id(true);
    $_SESSION['email'] = $email;
    $_SESSION['uid']   = $r['0'];
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome!</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #222;
                font-family: Arial, sans-serif;
                text-align: center;
                color: white;
                overflow: hidden;
            }

            .fade-container {
                opacity: 0;
                transform: scale(0.8);
                animation: fadeInScale 2s ease-in-out forwards;
            }

            @keyframes fadeInScale {
                0% { opacity: 0; transform: scale(0.8); }
                100% { opacity: 1; transform: scale(1); }
            }

            .glow-text {
                font-size: 24px;
                font-weight: bold;
                text-shadow: 0 0 10px #00ffcc, 0 0 20px #00ffcc, 0 0 30px #00ffcc;
            }

            .progress-bar {
                width: 100px;
                height: 4px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 10px;
                overflow: hidden;
                margin-top: 20px;
                position: relative;
            }

            .progress-bar::before {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                background: #00ffcc;
                transform: scaleX(0);
                transform-origin: left;
                animation: loadBar 2s linear forwards;
            }

            @keyframes loadBar {
                0% { transform: scaleX(0); }
                100% { transform: scaleX(1); }
            }
        </style>
    </head>
    <body>

        <div class="fade-container">
            <div class="glow-text">Welcome, <?php echo htmlspecialchars($email); ?>!</div>
            <p>Redirecting to your dashboard...</p>
            <div class="progress-bar"></div>
        </div>

        <script>
            setTimeout(function() {
                window.location.replace("bookdashboard.php");
            }, 2500); // 2.5 seconds delay before redirect
        </script>

    </body>
    </html>

    <?php
} else {

    // Login failed: blocked user or wrong email/password
    if ($row > 0 && $r['status'] == 'disapprove') {
        $msg = "Login failed! You are blocked by admin.";
    } else {
        $msg = "Wrong email or password. Try again.";
    }
    ?>
    <script>
        alert("<?php echo $msg; ?>");
        location.href = "userlogin.php";
    </script>
    <?php
}
?>
