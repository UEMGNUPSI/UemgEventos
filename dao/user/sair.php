<?php 
session_start();

unset($_SESSION['user']);
unset($_SESSION['admin']);

header("Location: ../../index.php");

 ?>
