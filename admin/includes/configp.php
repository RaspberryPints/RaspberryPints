<?php
		$dbhost     = "TapList45.db.10666578.hostedresource.com";
		$dbname     = "TapList45";
		$dbuser     = "TapList45";
		$dbpass     = "Deer!boy45";
		$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
		
		$stmt = $conn->prepare('SELECT * FROM config WHERE id <= 6');
		$stmt->execute();
		$result = $stmt->fetchAll();
?>
