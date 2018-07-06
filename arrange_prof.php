<?php
session_start();
// DBとの接続
include_once 'dbconnect.php';
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワードの変更</title>
<link rel="stylesheet" href="style.css">

<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<?php
// パスワードを変更するボタンが押されたときに下記を実行
if(isset($_POST['changepass'])) {
	$password = $mysqli->real_escape_string($_POST['password']);
	$password = password_hash($password, PASSWORD_BCRYPT);
	$user_id = $_SESSION['user'];

	// POSTされた情報をDBに格納する
	$query = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";

	if($mysqli->query($query)) {  ?>
		<div class="alert alert-success" role="alert">変更しました</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}
} ?>

<form method="post">
	<h1>パスワードの変更</h1>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="新しいパスワード" required />
	</div>
	<button type="submit" class="btn btn-default" name="changepass">パスワードを変更する</button>
	<a href="mypage.php">マイページに戻る</a>
</form>

</div>
</body>
</html>