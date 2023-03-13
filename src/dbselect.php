<!DOCTYPE html>														
<html lang="ja">														
<head>														
  <meta charset="UTF-8">														
  <title>dbselect.php</title>														
</head>														
<body>														
<?php														
	#$dsn = 'mysql:host=db;dbname=php;charset=utf8';	// データソース名・・データベースは「php」
	$dsn = 'mysql:host=db;dbname=php;charset=utf8';	// データソース名・・データベースは「php」	
	$user = 'kobe';										// ユーザー名	
	$password = 'denshi';										// パスワード	
														
	try {											
		$pdo = new PDO($dsn, $user, $password);											// データベースへ接続するオブジェクト作成	
		$sql = 'select  *  from  person';									// SQL文の定義	
		$stmt = $pdo->query($sql);											// SELECT文の実行	
		$results = $stmt->fetchAll( );											// 実行結果を連想配列の形で取り出す	
		foreach ( $results  as  $result ) {											// 配列のデータを1件ずつ処理する	
			echo '<p>uid=' . $result ['uid'] . ', name=' . $result ['name'] . '</p>';											
		}												
	} catch (Exception $e) {													
		echo 'Error:' . $e->getMessage();										
		die( );												
	}													
	$pdo = null;												// データベースへの接続を閉じる	
?>														
<hr>														
<h4>○○組　□□□番　神戸電子</h4>													
</body>															
</html>														
