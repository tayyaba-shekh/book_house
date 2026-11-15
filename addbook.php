
<?php include("user_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            margin: auto;
            box-shadow: 0px 0px 10px 0px #0000001a;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, button, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background: #218838;
        }
        .message {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a New Book</h1>
        
       
        <form action="add_b.php" method="POST" enctype="multipart/form-data">
            <label for="book_name">Book Name:</label>
            <input type="text" id="book_name" name="book_name" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="per_day_price">Per Day Price:</label>
            <input type="number" id="per_day_price" name="per_day_price" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="status">Book Status:</label>
            <select id="status" name="status" required>
                <option value="available">Available</option>
            </select>

            <label for="cover">Book Cover:</label>
            <input type="file" id="cover" name="cover" accept="image/*">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['uid']; ?>" required>
            <input type="submit" name="submit" VALUES="ADD BOOK">
            <a href="bookdashboard.php"><button type="button" style="width:100%; margin-top:10px; padding:10px; background:#6c757d; color:white; border:none; border-radius:5px; cursor:pointer;">Cancel</button></a>
        </form>
    </div>
</body>
</html>