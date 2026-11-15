<?php
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "book_house";

$conn = new mysqli($host, $user, $pass, $db);

if (isset($_POST['submit'])) {
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $price = $_POST['per_day_price'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $user_id = (int) $_POST['user_id'];
    $uploadDirectory = "./uploads/";

    if (move_uploaded_file($_FILES["cover"]["tmp_name"], $uploadDirectory . $_FILES["cover"]["name"])) {
        $cover = $_FILES["cover"]["name"];
        $sql = mysqli_query($conn, "INSERT INTO book VALUES (NULL, '$book_name', '$author', '$price', '$status', '$location', '$cover', '$user_id')");
    }

    if ($sql > 0) {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Success</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #222;
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

                .checkmark {
                    font-size: 50px;
                    color: #00ffcc;
                    display: inline-block;
                    transform: scale(0);
                    animation: popIn 1s ease-in-out forwards;
                }

                @keyframes popIn {
                    0% { transform: scale(0); opacity: 0; }
                    50% { transform: scale(1.2); opacity: 1; }
                    100% { transform: scale(1); }
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
                <div class="checkmark">✔</div>
                <h2>Book Added Successfully!</h2>
                <p>Redirecting to your dashboard...</p>
                <div class="loading-bar"></div>
            </div>

            <script>
                setTimeout(function() {
                    window.location.href = "bookdashboard.php";
                }, 2500); // Redirect after 2.5 seconds
            </script>

        </body>
        </html>

        <?php
    } else {
        ?>

        <script>
            alert("Book not added.");
            location.href = "addbook.php";
        </script>

        <?php
    }
}
?>
