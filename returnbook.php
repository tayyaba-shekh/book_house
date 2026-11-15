<?php
session_start();
<?php include("user_check.php"); ?>


$conn = mysqli_connect("localhost","root","","book_house");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Get rent_id from the URL
$rent_id = (int) ($_GET['rent_id'] ?? 0);
if (!$rent_id) {
    echo "No rent ID provided in the URL.";
    exit;
}

// 2. Fetch the rent record
$sql = "SELECT * FROM rent WHERE rent_id='$rent_id'";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "No rent record found for rent_id = $rent_id";
    exit;
}

$row = mysqli_fetch_assoc($result);

// 3. Extract the end_date from the rent record
$end_date = $row['end_date'] ?? '';

// 4. Calculate the current date
$current_date = date("Y-m-d");

// 5. Calculate penalty if current_date > end_date
$penalty = 0;
if ($end_date && $current_date > $end_date) {
    $endDateObj     = new DateTime($end_date);
    $currentDateObj = new DateTime($current_date);
    $interval       = $endDateObj->diff($currentDateObj);
    $lateDays       = $interval->days;
    $penalty        = $lateDays *10;
}

// 6. Get the user ID from session
$user_id = $_SESSION['uid'] ?? null;
if (!$user_id) {
    echo "User not logged in.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Return Book</title>
  <link rel="stylesheet" href="navigation.css" type="text/css">
  <!-- Simple inline CSS -->
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: #f4f4f4;
    }

    h1 {
      text-align: center;
      margin-top: 30px;
      color: #333;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    form label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    form input[type="number"],
    form input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    button[type="submit"] {
      display: inline-block;
      background: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border: none;
      border-radius: 4px;
      margin-top: 10px;
    }

    button[type="submit"]:hover {
      background: #45a049;
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
  <h1>Return Book</h1>

  <div class="container">
  <form action="returnup.php" method="post">
   
    <input type="hidden" id="rent_id" name="rent_id" value="<?php echo htmlspecialchars($rent_id); ?>" readonly required>
    
  
    <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" readonly required>
    
    <label for="end_date">End Date of returning book:</label>
    <input type="text" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" readonly required>
    
    <label for="current_date">Current Date :</label>
    <input type="text" id="current_date" name="current_date" value="<?php echo htmlspecialchars($current_date); ?>" readonly required>

    <input type="hidden" id="penalty" name="penalty" value="<?php echo htmlspecialchars($penalty); ?>">

    
     <?php if ($penalty > 0): ?>
            <label for="penalty">Penalty Payment (Rs.10 per day):</label>
            <input type="text" id="penalty" name="penalty" value="<?php echo htmlspecialchars($penalty); ?>" readonly required>

            <label>Select Payment Method:</label>
            <select name="p_method" required>
                <option value="">-- Choose Payment Method --</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="UPI">UPI</option>
                <option value="Cash">Cash</option>
            </select>
        <?php endif; ?>
    </select><br><br>
    
    <button type="submit">Confirm Return</button>
  </form>
</div>