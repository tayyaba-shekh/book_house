<?php include("admin_check.php"); ?>

<?php
include("db.php");

$id = (int) $_GET['id'];

$query=mysqli_query($conn,"UPDATE `user` SET `status` = 'approve' WHERE `u_id`='$id'");

if($query>0)
{
?>
<script>
alert("user is Approved");
location.href="user.php";
</script>
<?php
}
else
{
?>
<script>
alert("user has not Approved");
location.href="user.php";
</script>
<?php
}
?>