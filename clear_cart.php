<?php
session_start();
unset($_SESSION['cart_temp']);
header("Location: index.php");
exit();
?>