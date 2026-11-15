
<?php
session_start();
include("user_check.php");
$conn = mysqli_connect("localhost", "root", "", "book_house");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $b_id = mysqli_real_escape_string($conn, $_GET['book_id']);
    $query = "SELECT * FROM book WHERE b_id = '$b_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching book details: " . mysqli_error($conn));
    }

    $book = mysqli_fetch_assoc($result);
} else {
    die("Invalid request: Book ID is missing.");
}

if (isset($_POST['update'])) {
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $per_day_price = $_POST['per_day_price'];
    $location = $_POST['location'];

    // Handle Image Upload
    $cover = $book['cover'];
    if (!empty($_FILES['cover']['name'])) {
        $target_dir = "uploads/";
        $cover = $target_dir . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], $cover);
    }

    $update_query = "UPDATE book SET 
        name='$book_name', 
        author='$author', 
        per_day_price='$per_day_price', 
        location='$location', 
        cover='$cover'
        WHERE b_id=$b_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Book Update</title>
                  <style>
                      body {
                          font-family: Arial, sans-serif;
                          background-color: #f8f8f8;
                          margin: 0;
                          padding: 0;
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          height: 100vh;
                      }
                      .notification {
                          position: fixed;
                          top: -50px;
                          left: 50%;
                          transform: translateX(-50%);
                          background-color: #28a745;
                          color: white;
                          padding: 15px 30px;
                          border-radius: 8px;
                          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                          font-size: 18px;
                          font-weight: bold;
                          text-align: center;
                          animation: slideDown 0.5s ease-out forwards, fadeOut 0.5s 1.5s ease-in-out forwards;
                      }
                      @keyframes slideDown {
                          from { top: -50px; opacity: 0; }
                          to { top: 20px; opacity: 1; }
                      }
                      @keyframes fadeOut {
                          from { opacity: 1; }
                          to { opacity: 0; }
                      }
                  </style>
              </head>
              <body>
                  <div class='notification' id='notification'>
                      ✅ Book Updated Successfully!
                  </div>
                  <script>
                      setTimeout(() => {
                          window.location.href = 'bookdashboard.php';
                      }, 2000);
                  </script>
              </body>
              </html>";
        exit;
    } else {
        echo "<script>alert('Error updating book: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bookhouse - Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .nav {
            background-color: #333;
            padding: 10px;
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
        .edit-container {
            padding: 20px;
        }
        .edit-container form {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
        .edit-container input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
        .edit-container button {
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit-container img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="nav">
        <a href="bookdashboard.php">Home</a>
        <a href="addbook.php">Add Books</a>
        <a href="my_orders.php">Orders</a>
        <a href="userlogin.php">Logout</a>
        <a href="my_books.php">Back</a>
    </div>

    <div class="edit-container">
        <h2>Edit Book</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Book Name</label>
            <input type="text" name="book_name" value="<?php echo $book['name']; ?>" required>

            <label>Author</label>
            <textarea name="author" required><?php echo $book['author']; ?></textarea>

            <label>Per Day Price</label>
            <input type="number" name="per_day_price" value="<?php echo $book['per_day_price']; ?>" required>

            <label>Location</label>
            <input type="text" name="location" value="<?php echo $book['location']; ?>" required>

            <label>Current Book Cover</label><br>
            <img src="uploads/<?php echo $book['cover']; ?>" alt="Book Cover"><br>

            <label>Upload New Image</label>
            <input type="file" name="cover">

            <button type="submit" name="update">Update Book</button>
        </form>
    </div>
</body>
</html>
