<?php
include("db.php");

$id=$_GET['id'];

$query=mysqli_query($conn,"UPDATE `book` SET `approve/disapprove` = 'disapprove' WHERE `b_id`='$id'");

if($query>0)
{
?>
<script>
alert("book is disapproved");
location.href="book.php";
</script>
<?php
}
else
{
?>
<script>
alert("book has not disapproved");
location.href="book.php";
</script>
<?php
}
?>