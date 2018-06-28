<?php

$db_host = 'localhost';
$db_name = 'board_db';
$db_user = 'board_user';
$db_pass = 'board_pass';

$dataFile = 'bbs.dat';

#エスケープ関数の作成
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}
 
// データベースへ接続する
$link = mysqli_connect( $db_host, $db_user, $db_pass, $db_name );
if ( $link !== false ) {
//MySQLがつながった時の処理

#入力値の確認
	if ($_SERVER['REQUEST_METHOD']=='POST' &&
    	isset($_POST['message']) &&
    	isset($_POST['user'])){

    	$message = trim($_POST['message']);
    	$user = trim($_POST['user']);

	        #message がなかったときの処理
    	if ($message !== ''){
        	#$user がなかったときの処理
        	$user = ($user === '') ? 'noname' : $user;

	        #$message と $user に \t が含まれてた場合それを置き換える
    	    $message = str_replace("\t", ' ', $message);
        	$user = str_replace("\t", ' ', $user);

        	$postedAt = date('Y-m-d H-i-s');

        	// $newData = $message . "\t" . $user . "\t" . $postedAt. "\n";

        	// $fp = fopen($dataFile, 'a');
        	// fwrite($fp, $newData);
        	// fclose($fp);
        	$query = " INSERT INTO board ( "
                   . "    name , "
                   . "    comment , "
                   . "    time , "
                   . " ) VALUES ( "
                   . "'" . mysqli_real_escape_string( $link, $user ) ."', "
                   . "'" . mysqli_real_escape_string( $link, $message ) . "', "
                   . "'" . mysqli_real_escape_string( $link, $postedAt ) . "'"
                   ." ) ";
 
            $res   = mysqli_query( $link, $query );
            
            if ( $res !== false ) {
                $msg = '書き込みに成功しました';
            }else{
                $err_msg = '書き込みに失敗しました';
            }	
    	}else{
    		$err_msg = 'コメントを記入してください';
    	}
	}

	$query  = "SELECT id, name, comment FROM board";
    $res    = mysqli_query( $link,$query );
    $data = array();
    while( $row = mysqli_fetch_assoc( $res ) ) {
        array_push( $data, $row);
    }
    arsort( $data );

} else {
    echo "データベースの接続に失敗しました。";
}

// $posts = file($dataFile, FILE_IGNORE_NEW_LINES);

// $posts = array_reverse($posts);

// データベースへの接続を閉じる
mysqli_close( $link );
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>BBS</title>
</head>
<body>
    <h1>BBS</h1>
    <form action="" method="post">
        message: <input type="text" name="message">
        user: <input type="text" name="user">
        <input type="submit" value="投稿">
    </form>
    <h2>投稿一覧(<?php echo count($posts); ?>件)</h2>
    <ul>
        <?php if (count($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
            <?php list($message, $user, $postedAt) = explode("\t", $post); ?>
                <li><?php echo h($message); ?> (<?php echo h($user); ?>) - <?php echo h($postedAt); ?></li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>まだ投稿はありません</li>
        <?php endif; ?>
    </ul>
</body>
</html>