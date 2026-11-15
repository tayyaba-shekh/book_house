<?php include("admin_check.php"); ?>
<?php
include("db.php");

$id = (int) $_GET['id'];
$query=mysqli_query($conn,"DELETE FROM book WHERE `book`.`b_id` = '$id'");
 
if($query>0)
{
?>
<script>
alert("book is Deleted");
location.href="book.php";
</script>
<?php
}
else
{
?>
<script>
alert("book is  not deleted");
location.href="book.php";
</script>
<?php
}
