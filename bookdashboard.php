<?php
// Start session
session_start();
include("user_check.php");


// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "book_house";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT book.*,
        (SELECT MAX(rent.end_date) FROM rent WHERE rent.b_id = book.b_id AND rent.status = 'rented') AS available_from
        FROM book";
$result = $conn->query($sql);

// Assuming user ID is stored in session
$user_id = $_SESSION['uid'];
// Fetch user details
$user_sql = "SELECT profile_picture FROM user WHERE u_id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

// Use default profile picture if none exists
$profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookhouse Dashboard</title>
    
    <style>
        body {
            font-family: "Georgia", sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
        }
        /* Profile Section */
        .profile {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #f3f4f6;
            border-radius: 12px;
        }
        .profile a {
            text-decoration: none;
        }
        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            cursor: pointer;
        }
        .profile h2 {
            font-size: 20px;
            margin: 0;
            color: #1f2937;
        }
        .profile p {
            margin: 4px 0;
            color: #4b5563;
        }
        /* Buttons */
        button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4f46e5;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #3730a3;
        }
        .rent-btn {
            background-color: #10b981;
        }
        .rent-btn:hover {
            background-color: #059669;
        }
        /* Table */
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
        td img {
            width: 50px;
            height: 75px;
            object-fit: cover;
            border-radius: 8px;
        } 
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Section (Clickable Image) -->
        <div class="profile">
            <a href="user_profile.php?user_id=<?php echo $user_id; ?>">
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
            </a>
            <div>
                <h2><?php echo $email=$_SESSION['uid']?></h2>
                <p>Librarian | Book Enthusiast</p>
            </div>
        </div>

        <h1>Bookhouse Dashboard</h1>
        <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
    <button onclick="window.location.href='addbook.php'">Add Book</button>
   
    </div>
    <div>
        <button class="btn btn-info" onclick="location.href='my_books.php'">My Books</button>
        <button class="btn btn-warning" onclick="location.href='my_orders.php'">My Orders</button>
    </div>
</div>

        <input type="text" id="searchInput" oninput="searchBooks()" placeholder="Search books...">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Per Day Price</th>
                    <th>Status</th>
                    <th>Available From</th>
                    <th>Location</th>
                    <th>Cover</th>
                    <th>Rent</th>
                    
                </tr>
            </thead>
            <tbody id="bookTable">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            if ($row['status'] == 'available') {
                $statusText    = "Available";
                $availableInfo = "Now";
                $btn = "<a href='rentbook.php?b_id={$row['b_id']}'><button class='rent-btn'>Rent</button></a>";
            } else {
                $statusText    = "Rented";
                $availableInfo = "-";

                if ($row['available_from']) {
                    $dueDate = date('d M Y', strtotime($row['available_from']));

                    if ($row['available_from'] < date('Y-m-d')) {
                        $lateDays = (new DateTime($row['available_from']))->diff(new DateTime(date('Y-m-d')))->days;
                        $statusText    = "<span style='color:red; font-weight:bold;'>Delayed ($lateDays day" . ($lateDays > 1 ? "s" : "") . ")</span>";
                        $availableInfo = "<span style='color:red;'>Was due $dueDate</span>";
                    } else {
                        $availableInfo = $dueDate;
                    }
                }

                $btn = "<button class='rent-btn' disabled style='opacity:0.5; cursor:not-allowed;'>Rented</button>";
            }

            echo "<tr>
                    <td>{$row['b_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['per_day_price']}</td>
                    <td>$statusText</td>
                    <td>$availableInfo</td>
                    <td>{$row['location']}</td>
                    <td><img src='uploads/{$row['cover']}' alt='Book Cover'></td>
                    <td>$btn</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No books found</td></tr>";
    }
    ?>
</tbody>
        </table>
    </div>

    <script>
        function searchBooks() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#bookTable tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(input));
                row.style.display = match ? '' : 'none';
            });
        }

        function rentBook(bookId) {
            window.location.href = "rentbook.php?book_id=" + bookId;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
