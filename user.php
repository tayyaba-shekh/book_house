<?php include("admin_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="table.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php">Dashboard</a><br>
        <a href="user.php">User Management</a><br>
        <a href="book.php">Book Management</a><br>
        <a href="payment.php">Payment Management</a>
        <a href="logout.php">Logout</a>
        </div>
        </div>

    <div class="content">
        <h1>User Management</h1>
        <table>
            <thead>
            
                <th>User ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>Email</th>
                <th>Password</th>
                <th>status</th>
                <th>Approve</th>
                <th>Disapprove</th>
                

            </tr>
        </thead>
        <tbody>
        <?php
        include("db.php");
        $query=mysqli_query($conn,"select * from user");
        if($row=mysqli_num_rows($query) > 0) 
        {
            while ($row=mysqli_fetch_row($query)) {
            ?> <tr>
                <td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>            
			    <td><?php echo $row[3];?></td>
			    <td><?php echo $row[4];?></td>
     			<td><?php echo $row[5];?></td>
                <td><?php echo $row[6];?></td>
			    <td><a href="uapprove.php?id=<?php echo $row[0]?>"><img src='approve.jpeg' height='80' width='80' /></a></td>
			    <td><a href="udisapprove.php?id=<?php echo $row[0]?>"><img src='disapprove.jpeg' height='80' width='80' /></a></td>
                            </tr>
			    <?php
                            }
                            echo "";
                            }
                            else {
                            echo "No data in table.";
                            }
			    ?>
                
            </tbody>
        </table>
