<?php
	session_start();
	if (!isset($_SESSION['usuario_id']))
		header("location:entrar.php");
?>