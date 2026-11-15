<?php
session_start();
session_destroy();
header("Location: house.html");
exit();
?>