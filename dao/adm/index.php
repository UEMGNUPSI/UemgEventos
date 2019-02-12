<?php

session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /public/?erro=".base64_encode(9));
	die();
}