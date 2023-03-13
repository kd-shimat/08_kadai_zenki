<!DOCTYPE html>						
<html lang="ja">						
<head>						
  <meta charset="UTF-8">						
  <title>dbupdate.php</title>						
</head>						
<body>						
<?php						
	$dsn = 'mysql:host=localhost;dbname=php;charset=utf8';					
	$user = 'kobe';					
	$password = 'denshi';					
						
	try{					
		$pdo = new PDO($dsn, $user, $password);				
		$sql = 'update person set name = ? where  uid  =  ?';				
		$stmt = $pdo->prepare($sql);				
		$stmt->execute(['野口五郎',  5]);				
						
		$sql = 'select * from person';				
		$stmt = $pdo->query ($sql );				
		$results = $stmt->fetchAll( );				
		foreach ( $results  as  $result ) {				
			echo 'uid=' . $result ['uid'] . ', name=' . $result ['name'] . '<br>';			
		}				
	}catch (Exception $e){					
		echo 'Error:' . $e->getMessage();				
		die( );				
	}					
	$pdo = null;					
?>						
<hr>						
<h4>○○組　□□□番　神戸電子</h4>						
</body>						
</html>						
