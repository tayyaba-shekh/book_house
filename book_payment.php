<?php session_start(); ?>
<?php include("user_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Book</title>
  <?php
    $userid = $_SESSION['uid'];
    $bid = (int) $_GET['bid'];
    $conn = mysqli_connect("localhost", "root", "", "book_house");

    $sql = mysqli_query($conn, "SELECT * FROM rent WHERE u_id='$userid' AND status='pending' AND b_id='$bid' ORDER BY rent_id DESC LIMIT 1");
    $row = mysqli_fetch_array($sql);
  ?>
  <style>


    body {
      background: #f4f4f4;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    /* Page heading */
    h1 {
      text-align: center;
      color: #333;
      margin-top: 30px;
    }
    /* Form container styling */
    form {
      max-width: 500px;
      background: #fff;
      margin: 50px auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    /* Label styling */
    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    /* Input and select styling */
    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      box-sizing: border-box;
    }
    /* Readonly input styling */
    input[readonly] {
      background-color: #e9ecef;
      cursor: not-allowed;
    }
    /* Submit button styling */
    button {
      width: 100%;
      padding: 10px;
      background: #4CAF50;
      border: none;
      color: #fff;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <h1>Payment Book</h1> 
  <form action="pay_b.php" method="post">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['uid']; ?>" required>
<input type="hidden" id="rent_id" name="rent_id" value="<?php echo $row['0']; ?>" required>
    
    <label for="amount">Total Amount:</label>
    <input type="number" id="amount" name="amount" value="<?php echo $row['3']; ?>" readonly>
    
    <label>Select Payment Method:</label>
    <select name="p_method" required>
      <option value="">-- Choose Payment Method --</option>
      <option value="Credit Card">Credit Card</option>
      <option value="Debit Card">Debit Card</option>
      <option value="PayPal">PayPal</option>
      <option value="UPI">UPI</option>
      <option value="Cash">Cash</option>
    </select>
    
    <button type="submit">Make Payment</button>
    <a href="bookdashboard.php"><button type="button" style="margin-top:10px; background:#6c757d; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Back</button></a>

<a href="cancel_rent.php?rent_id=<?php echo $row['0']; ?>" onclick="return confirm('Cancel this rent?');"><button type="button" style="margin-top:10px; background:#dc3545; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Cancel Rent</button></a></body>
</html>
