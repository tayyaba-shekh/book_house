<?php
// Start session
session_start();
include("user_check.php");

$conn = mysqli_connect("localhost", "root", "", "book_house");

// Assuming user ID is stored in session
$user_id = $_SESSION['uid'];
// Fetch rented books for the logged-in user
$sql = "SELECT rent.rent_id, rent.start_date, rent.end_date, rent.amount, rent.b_id,
               rent.status AS rent_status, book.name AS book_name
        FROM rent
        JOIN book ON rent.b_id = book.b_id
        WHERE rent.u_id = '$user_id'
        ORDER BY rent.rent_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #333;
        }

        /* Navigation Bar */
        .nav {
            background-color: #333;
            padding: 10px;
            text-align: center;
        }
        .nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .nav a:hover {
            background-color: #575757;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Heading */
        h1 {
            text-align: center;
            font-size: 28px;
            color: #1f2937;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border: 1px solid #e5e7eb;
        }
        th {
            background-color: #f3f4f6;
            font-size: 16px;
            color: #1f2937;
        }
        td {
            font-size: 14px;
            color: #4b5563;
        }

        /* Button Styling */
        .return-btn {
            padding: 8px 16px;
            border: none;
            background-color: #e11d48; /* Red button */
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .return-btn:hover {
            background-color: #b91c1c;
        }

        /* Footer */
        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Panel -->
    <div class="nav">
        <a href="bookdashboard.php">Home</a>
        <a href="addbook.php">Add Books</a>
        <a href="my_orders.php">Orders</a>
        <a href="ulogout.php">Logout</a>
    </div>

    <!-- Orders Container -->
    <div class="container">
        <h1>My Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>RentID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Amount</th>
                    <th>BOOK</th>
                    <th>Status</th>
                    <th>Return</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                         <td>{$row['rent_id']}</td>
                         <td>{$row['start_date']}</td>
                         <td>{$row['end_date']}</td>
                         <td>{$row['amount']}</td>
                         <td>{$row['book_name']}</td>
                         <td>{$row['rent_status']}</td>";

    if ($row['rent_status'] == 'rented') {
    echo "<td>
            <a href='returnbook.php?rent_id={$row['rent_id']}'>
                <button class='return-btn'>Return</button>
            </a>
          </td>";
} elseif ($row['rent_status'] == 'pending') {
    echo "<td>
            <a href='book_payment.php?bid={$row['b_id']}'>
                <button class='return-btn'>Pay Now</button>
            </a>
          </td>";
} elseif ($row['rent_status'] == 'cancelled') {
    echo "<td>Cancelled</td>";
} else {
    echo "<td>Returned</td>";
}
    echo "</tr>";
}
                    }
                 else {
                    echo "<tr><td colspan='7'>No rented books found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2025 Book House. All Rights Reserved.
    </footer>
</body>
</html>

<?php $conn->close(); ?>
