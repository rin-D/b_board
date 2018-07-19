<?php
 
header("Content-type: text/html; charset=utf-8");
session_start();
include_once("dbconnect.php");
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}

if(empty($_POST)) {
	echo "<a href='mypage.php'>マイページに戻る</a>";
	exit();
}else{
	//名前入力チェック
	if (!isset($_POST['comment'])  || $_POST['comment'] === "" ){
		echo "コメントが入力されていません。";
	}
	
	else{
		//プリペアドステートメント
		$stmt = $mysqli->prepare("UPDATE board SET comment=? WHERE id=?");
		if ($stmt) {
			//プレースホルダへ実際の値を設定する
			$stmt->bind_param('si', $comment, $id);
			$comment = $_POST['comment'];
			$id = $_POST['id'];
			
			//クエリ実行
			$stmt->execute();
			//ステートメント切断
			$stmt->close();
		}else{
			echo $mysqli->errno . $mysqli->error;
		}
	}
}
 
// データベース切断
$mysqli->close();
		
?>
 
<!DOCTYPE html>
<html>
<head>
<title>変更画面</title>
</head>
<body>
<h1>変更画面</h1> 
	echo "変更完了しました";
</body>
</html>