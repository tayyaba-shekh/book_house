
<?php include("admin_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
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
        <h1>Book Management</h1>
        <table>
            <thead>
            
                <th>Book ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Per_day_price</th>
                <th>status</th>
                <th>location</th>
                <th>book_cover</th>
        
                <th>Delete</th>
                
                

            </tr>
        </thead>
        <tbody>
        <?php
        include("db.php");
        $query=mysqli_query($conn,"select * from book");
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
                

			    <td><a href="bapprove.php?id=<?php echo $row[0]?>"><img src='https://cdn1.vectorstock.com/i/1000x1000/46/75/delete-button-square-red-with-chrome-frame-vector-19994675.jpg' height='100' width='100' /></a></td>
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
