<?php

/*
i'm to lazy to translate prefixes lol
*/
	session_start();
	
	if ((!isset($_POST['user'])) || (!isset($_POST['Password'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "authconfig.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$email = $_POST['email'];
		$user = $_POST['user'];
		$Password = $_POST['Password'];
		$email = $_POST['email'];
		
		$user = htmlentities($user, ENT_QUOTES, "UTF-8");
		$Password = htmlentities($Password, ENT_QUOTES, "UTF-8");
	
		if ($result = @$polaczenie->query(
		sprintf("SELECT * FROM users WHERE user='%s' AND pass='%s'",
		mysqli_real_escape_string($polaczenie,$user),
		mysqli_real_escape_string($polaczenie,$Password))))
		{
			$ilu_userow = $result->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['logged'] = true;
				
				$wiersz = $result->fetch_assoc();
				$_SESSION['id'] = $wiersz['id'];
				$_SESSION['user'] = $wiersz['user'];
				$_SESSION['Password'] = $wiersz['Password'];
				$_SESSION['email'] = $wiersz['email'];

				
				unset($_SESSION['error']);
				$result->free_result();
				header('Location: index.php');
				
			} else {
				
				$_SESSION['error'] = '<span style="color:red">Nieprawidłowy user lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>