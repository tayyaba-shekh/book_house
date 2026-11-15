<?php include("admin_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="user.php">User Management</a>
        <a href="book.php">Book Management</a>
        <a href="payment.php">Payment Management</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h1>Admin Dashboard</h1>
        <div class="cards">
            <div class="card">Total number of <br>USERS: <?php

                $conn=mysqli_connect("localhost","root","","book_house");

                $sql=mysqli_query($conn,"SELECT COUNT(*) AS total FROM user");
                $row=mysqli_fetch_array($sql);
                echo $row['0'];?>
                </div>
            <div class="card">Total number of<br>BOOKS: <?php
                            $conn=mysqli_connect("localhost","root","","book_house");

                            $sql=mysqli_query($conn,"SELECT COUNT(*) AS total FROM book");
                            $row=mysqli_fetch_array($sql);
                            echo $row['0'];?>
            

            <div class="card">Total number of<br>PAYMENTS: <?php 
                                            $conn=mysqli_connect("localhost","root","","book_house");

                                            $sql=mysqli_query($conn,"SELECT COUNT(*) AS total FROM payment");
                                            $row=mysqli_fetch_array($sql);
                                            echo $row['0'];?>
                            
        </div>
    </div>
</body>
</html>
