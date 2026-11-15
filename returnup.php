<?php
session_start();
<?php include("user_check.php"); ?>
$conn = mysqli_connect("localhost", "root", "", "book_house");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve posted values
$rent_id      = $_POST['rent_id'];
$user_id      = $_POST['user_id'];
$current_date = $_POST['current_date'];
$penalty      = isset($_POST['penalty']) ? $_POST['penalty'] : 0; // Default to 0 if not set
$p_method = isset($_POST['p_method']) ? $_POST['p_method'] : '';

// 1. Insert the return record into the return_book table
$insertQuery = "INSERT INTO return_book (rid, return_date, amount, rent_id, uid)
                VALUES (NULL, '$current_date', '$penalty', '$rent_id', '$user_id')";
$resultInsert = mysqli_query($conn, $insertQuery);

if ($resultInsert) {
    // 2. Update book status to 'available'
       // 2. Update book status to 'available'
    $rentRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT b_id FROM rent WHERE rent_id = '$rent_id'"));
    $b_id = $rentRow['b_id'];
    $updateBook = mysqli_query($conn, "UPDATE book SET status = 'available' WHERE b_id = '$b_id'");    
    // 3. Update rent record status to 'return'
    $updateRent = mysqli_query($conn, "UPDATE rent SET status = 'return' WHERE rent_id = '$rent_id'");
    // Save the penalty as a payment record
if ($penalty > 0) {
    mysqli_query($conn, "INSERT INTO payment (p_method, amount, rentid, u_id) VALUES ('$p_method', '$penalty', '$rent_id', '$user_id')");
}

    if ($updateBook && $updateRent) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Returning Book</title>
                  <style>
                      body {
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          height: 100vh;
                          background-color: #f8f8f8;
                          font-family: Arial, sans-serif;
                      }
                      .popup {
                          width: 300px;
                          background: white;
                          padding: 20px;
                          text-align: center;
                          border-radius: 10px;
                          box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                          transform: scale(0.5);
                          opacity: 0;
                          animation: popUp 0.5s forwards;
                      }
                      @keyframes popUp {
                          to {
                              transform: scale(1);
                              opacity: 1;
                          }
                      }
                      .loader {
                          border: 5px solid #f3f3f3;
                          border-top: 5px solid #4CAF50;
                          border-radius: 50%;
                          width: 40px;
                          height: 40px;
                          animation: spin 1s linear infinite;
                          margin: 10px auto;
                      }
                      @keyframes spin {
                          0% { transform: rotate(0deg); }
                          100% { transform: rotate(360deg); }
                      }
                      .success {
                          font-size: 18px;
                          color: #4CAF50;
                          margin-top: 10px;
                      }
                  </style>
              </head>
              <body>
                  <div class='popup'>
                      <div class='loader'></div>
                      <p class='success'>Book Returned Successfully!</p>
                  </div>
                  <script>
                      setTimeout(() => {
                          window.location.href = 'my_orders.php';
                      }, 2000); // Redirect after 2 seconds
                  </script>
              </body>
              </html>";
        exit;
    }
}

// If there's an error
echo "<!DOCTYPE html>
      <html lang='en'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Returning Book</title>
          <style>
              body {
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  height: 100vh;
                  background-color: #f8f8f8;
                  font-family: Arial, sans-serif;
              }
              .popup {
                  width: 300px;
                  background: white;
                  padding: 20px;
                  text-align: center;
                  border-radius: 10px;
                  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                  transform: scale(0.5);
                  opacity: 0;
                  animation: popUp 0.5s forwards;
              }
              @keyframes popUp {
                  to {
                      transform: scale(1);
                      opacity: 1;
                  }
              }
              .error {
                  font-size: 18px;
                  color: #e74c3c;
                  margin-top: 10px;
              }
          </style>
      </head>
      <body>
          <div class='popup'>
              <p class='error'>Book Return Failed!</p>
          </div>
          <script>
              setTimeout(() => {
                  window.location.href = 'my_orders.php';
              }, 2000); // Redirect after 2 seconds
          </script>
      </body>
      </html>";

mysqli_close($conn);
?>
