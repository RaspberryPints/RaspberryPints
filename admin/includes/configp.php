<?php
		$dbhost     = "localhost";
		$dbname     = "raspberrypints";
		$dbuser     = "beer";
		$dbpass     = "beer";
		$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
		
		$stmt = $conn->prepare('SELECT * FROM config WHERE id <= 6');
		$stmt->execute();
		$result = $stmt->fetchAll();
?>
