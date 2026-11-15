<?php
// Start session
session_start();
include("user_check.php");

$conn = mysqli_connect("localhost", "root", "", "book_house");

// Check if book ID is set
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['uid']; // Get the logged-in user's ID

    // Verify that the logged-in user owns the book before deleting
    $check_query = "SELECT * FROM book WHERE b_id = '$book_id' AND uid = '$user_id'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Delete the book
        $delete_query = "DELETE FROM book WHERE b_id = '$book_id' AND uid = '$user_id'";
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('✅ Book Deleted Successfully!', 'success');
                        setTimeout(function() {
                            window.location.href='my_books.php';
                        }, 1500);
                    });
                  </script>";
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('❌ Error Deleting Book!', 'error');
                        setTimeout(function() {
                            window.location.href='my_books.php';
                        }, 1500);
                    });
                  </script>";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Deleting Book...</title>
    <style>
        /* Fast Fade-in & Slide Animation */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            opacity: 0;
            transform: translateY(-5px);
            animation: fadeSlide 0.4s ease-in-out forwards;
        }
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Fast Pulsating Loader */
        .loader {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #3498db;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 0.8s infinite ease-in-out;
        }
        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
        }

        /* Fast Notification Box */
        .notification {
            position: fixed;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 20px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .success { background: #2ecc71; } /* Green */
        .error { background: #e74c3c; } /* Red */

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="loader"></div>

    <!-- Notification Box -->
    <div class="notification" id="notificationBox"></div>

    <script>
        function showNotification(message, type) {
            document.querySelector('.loader').style.display = 'none';
            let notification = document.getElementById('notificationBox');
            notification.textContent = message;
            notification.className = 'notification ' + type;
            notification.style.display = 'block';
        }
    </script>

</body>
</html>
