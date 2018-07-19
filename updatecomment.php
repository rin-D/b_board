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
	if (!isset($_POST['id'])  || !is_numeric($_POST['id']) ){
		echo "IDエラー";
		exit();
	}else{
		//プリペアドステートメント
		$stmt = $mysqli->prepare("SELECT * FROM board WHERE id=?");
		if ($stmt) {
			//プレースホルダへ実際の値を設定する
			$stmt->bind_param('i', $id);
			$id = $_POST['id'];
			
			//クエリ実行
			$stmt->execute();
			
			//結果変数のバインド
			$stmt->bind_result($id,$comment);
			// 値の取得
			$stmt->fetch();
						
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
 
<p>コメントを変更して下さい。</p>
<form action="updatecomment2.php" method="post">
<input type="text" name="comment" value="<?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="submit" value="変更する">
</form>
 
</body>
</html>
