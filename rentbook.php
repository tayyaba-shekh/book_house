<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Book</title>

    <style>
        /* Reset some default styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        /* Navigation bar */
        .nav {
            background-color: #333;
            padding: 10px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Navigation links */
        .nav a {
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
            border-radius: 5px;
        }

        /* Hover effect */
        .nav a:hover {
            background-color: #575757;
        }

        /* Page title */
        h1 {
            color: #333;
            margin-top: 20px;
        }

        /* Form container */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            text-align: left;
        }

        /* Labels */
        form label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        /* Input fields */
        form input[type="date"],
        form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Read-only input styling */
        form input[readonly] {
            background-color: #e9ecef;
        }

        /* Submit button */
        form button {
            width: 100%;
            background-color: #007BFF;
            border: none;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                text-align: center;
                padding: 10px;
            }

            .nav a {
                display: block;
                padding: 10px;
            }

            form {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <div class="nav">
        <a href="bookdashboard.php">Home</a>
        <a href="addbook.php">Add books</a>
        <a href="my_orders.php">Orders</a>
        <a href="userlogin.php">Logout</a>
    </div>

    <?php 
    // Get the book id and fetch book details
    $b_id = $_GET['b_id'];   
    $conn = mysqli_connect("localhost", "root", "", "book_house");
    $sql = mysqli_query($conn, "SELECT * FROM book WHERE b_id='$b_id'");
    $row = mysqli_fetch_array($sql);
    ?>

    <script>
        function calculateAmount() {
            // Retrieve price per day from PHP
            let pricePerDay = <?php echo $row['3']; ?>;
            let startDate = new Date(document.getElementById("start_date").value);
            let endDate = new Date(document.getElementById("end_date").value);

            if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                let timeDiff = endDate.getTime() - startDate.getTime();
                let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (dayDiff > 0) {
                    document.getElementById("amount").value = dayDiff * pricePerDay;
                } else {
                    document.getElementById("amount").value = 0;
                }
            }
        }
    </script>

    <h1>Rent Book</h1>
    
    <form action="ren_b.php" method="post">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['uid']; ?>" required>
        <input type="hidden" id="book_id" name="b_id"  value="<?php echo $b_id; ?>" required>

        <label for="start_date">Start Date:</label>
<?php
    $today    = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
?>
<input type="date" id="start_date" name="start_date" value="<?php echo $today; ?>" readonly required>

<label for="end_date">End Date:</label>
<input type="date" id="end_date" name="end_date" min="<?php echo $tomorrow; ?>" required onchange="calculateAmount()">
        

        <label for="amount">Total Amount:</label>
        <input type="number" id="amount" name="amount" readonly>

        <button type="submit">Rent Book</button>
    </form>
        </form>

<script>
  // Browser Back button on the rent form should go to the dashboard
  history.pushState(null, '', location.href);
  window.onpopstate = function () {
    location.replace('bookdashboard.php');
  };
</script>
</body>
</html>

</body>
</html>
