<?php include("user_check.php"); ?>
<?php
$conn = mysqli_connect("localhost", "root", "", "book_house");

$user_id = $_POST['user_id'];
$book_id = $_POST['b_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$amount = $_POST['amount'];
$status = "pending";
$today = date('Y-m-d');
if ($start_date != $today || $end_date <= $start_date) {
    echo "<script>alert('Invalid dates. Start date must be today and end date must be after it.'); location.href='bookdashboard.php';</script>";
    exit();
}

$chk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM book WHERE b_id = '$book_id'"));
if (!$chk || $chk['status'] != 'available') {
    echo "<script>alert('This book is already rented.'); location.href='bookdashboard.php';</script>";
    exit();
}
// Cancel old unpaid rents of this user for this book
mysqli_query($conn, "UPDATE rent SET status = 'cancelled' WHERE u_id = '$user_id' AND b_id = '$book_id' AND status = 'pending'");

// Insert into the database
$sql = mysqli_query($conn, "INSERT INTO rent (start_date, end_date, amount, u_id, b_id, status) VALUES ('$start_date', '$end_date', '$amount', '$user_id', '$book_id', '$status')");
if ($sql > 0) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rental Success</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #111;
                font-family: Arial, sans-serif;
                text-align: center;
                color: white;
                overflow: hidden;
            }

            .success-container {
                opacity: 0;
                transform: translateY(-50px);
                animation: slideIn 1.5s ease-out forwards;
            }

            @keyframes slideIn {
                0% { opacity: 0; transform: translateY(-50px); }
                100% { opacity: 1; transform: translateY(0); }
            }

            .book-icon {
                font-size: 50px;
                display: inline-block;
                color: #00ffcc;
                animation: bounce 1.5s infinite alternate;
            }

            @keyframes bounce {
                0% { transform: translateY(0); }
                100% { transform: translateY(-10px); }
            }

            .loading-bar {
                width: 150px;
                height: 5px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 10px;
                overflow: hidden;
                margin-top: 20px;
                position: relative;
            }

            .loading-bar::before {
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

        <div class="success-container">
            <div class="book-icon">📖</div>
            <h2>Book Rented Successfully!</h2>
            <p>Redirecting to payment...</p>
            <div class="loading-bar"></div>
        </div>

        <script>
    setTimeout(function() {
        window.location.replace("book_payment.php?bid=<?php echo $book_id; ?>");
    }, 2500); // Redirect after 2.5 seconds
</script>
    </body>
    </html>

    <?php
} else {
    ?>

    <script>
        alert("Book not rented.");
        location.href = "bookdashboard.php";
    </script>

    <?php
}
?>
