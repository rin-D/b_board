<?php
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}


// ユーザーIDからユーザー名を取り出す

$query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);

if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}
// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
	$username = $row['username'];
	$email = $row['email'];
}


// ユーザー名を指定してコメントを表示

$query = " SELECT * FROM board WHERE user_id=".$_SESSION['user']."";
$res = $mysqli->query($query);
if (!$res) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}
// コメントの取り出し
$data = array();

while ($row = $res->fetch_assoc()) {
	$id = $row['id'];
	$comment = $row['comment'];
	array_push($data, $row);
}
arsort( $data );

// データベースの切断
$result->close();

?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>マイページ</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<h1>プロフィール</h1>
<ul>
	<li>名前：<?php echo $username; ?></li>
	<li>メールアドレス：<?php echo $email; ?></li>
</ul>
<a href="home.php?home">トップに戻る</a>
<br>
<a href="arrange_prof.php?arrange_prof">パスワードの変更</a>
<br>
<a href="logout.php?logout">ログアウト</a>
<h2>あなたの投稿</h2>

<table border='1'>
<tr><td>コメント</td><td>コメントを編集する</td><td>コメントを削除する</td></tr>

<?php	
    foreach( $data as $key => $val ){
?>

<tr>
        <td><?=$val['comment']?></td>
        <td>
       		<form action="updatecomment.php" method="post">
			<input type="submit" value="編集する">
			<input type="hidden" name="id" value= "<?php echo $val['id']; ?>">
			</form>
		</td>
		<td>
			<form action="deletecomment.php" method="post">
			<input type="submit" value="削除する">
			<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
			</form>
		</td>
</tr>

<?php
    }	
?>

</div>
</body>
</html>