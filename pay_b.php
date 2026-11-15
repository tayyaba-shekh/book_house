<?php include("user_check.php"); ?>
<?php
$conn = mysqli_connect("localhost", "root", "", "book_house");

$user_id = $_POST['user_id'];
$rent_id = $_POST['rent_id'];
$amount = $_POST['amount'];
$p_method = $_POST['p_method'];
// Make sure this rent is still waiting for payment
$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT b_id FROM rent WHERE rent_id = '$rent_id' AND status = 'pending'"));
if (!$r) {
    echo "<script>alert('This rent is not valid or already paid.'); location.href='my_orders.php';</script>";
    exit();
}
$b_id = $r['b_id'];

// Make sure nobody else rented this book in the meantime
$bk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM book WHERE b_id = '$b_id'"));
if ($bk['status'] != 'available') {
    mysqli_query($conn, "UPDATE rent SET status = 'cancelled' WHERE rent_id = '$rent_id'");
    echo "<script>alert('Sorry, this book was rented by someone else.'); location.href='bookdashboard.php';</script>";
    exit();
}

// Insert into the database
$sql = mysqli_query($conn, "INSERT INTO payment (p_method, amount, rentid, u_id) VALUES ('$p_method', '$amount', '$rent_id', '$user_id')");
mysqli_query($conn, "UPDATE rent SET status = 'rented' WHERE rent_id = '$rent_id'");
mysqli_query($conn, "UPDATE book SET status = 'not available' WHERE b_id = '$b_id'");
// Cancel everyone else's unpaid rent for this same book
mysqli_query($conn, "UPDATE rent SET status = 'cancelled' WHERE b_id = '$b_id' AND status = 'pending' AND rent_id != '$rent_id'");
if ($sql > 0) {
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Success</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #0a0a0a;
                font-family: Arial, sans-serif;
                text-align: center;
                color: white;
                overflow: hidden;
            }

            .success-container {
                opacity: 0;
                transform: scale(0.8);
                animation: fadeInScale 1s ease-out forwards;
            }

            @keyframes fadeInScale {
                0% { opacity: 0; transform: scale(0.8); }
                100% { opacity: 1; transform: scale(1); }
            }

            .payment-icon {
                font-size: 50px;
                display: inline-block;
                color: #FFD700;
                animation: floatUp 1.5s infinite alternate ease-in-out;
            }

            @keyframes floatUp {
                0% { transform: translateY(0); }
                100% { transform: translateY(-10px); }
            }

            .checkmark {
                font-size: 50px;
                color: #32CD32;
                margin-top: 15px;
                animation: rotateIn 1s ease-in-out;
            }

            @keyframes rotateIn {
                0% { transform: rotate(-180deg) scale(0.5); opacity: 0; }
                100% { transform: rotate(0) scale(1); opacity: 1; }
            }

            .countdown {
                margin-top: 10px;
                font-size: 18px;
                opacity: 0;
                animation: fadeIn 1s 1.5s forwards;
            }

            @keyframes fadeIn {
                0% { opacity: 0; }
                100% { opacity: 1; }
            }
        </style>
    </head>
    <body>

        <div class="success-container">
            <div class="payment-icon">💳</div>
            <h2>Payment Successful!</h2>
            <div class="checkmark">✅</div>
            <p class="countdown">Redirecting to dashboard in <span id="timer">3</span> seconds...</p>
        </div>

        <script>
            let count = 3;
            let timer = setInterval(() => {
                count--;
                document.getElementById("timer").innerText = count;
                if (count <= 0) {
                    clearInterval(timer);
                    window.location.href = "bookdashboard.php";
                }
            }, 1000);
        </script>

    </body>
    </html>

<?php
} else {
    ?>

    <script>
        alert("Unsuccessful payment.");
        location.href = "my_orders.php";
    </script>

<?php
}
?>
