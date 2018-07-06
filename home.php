<?php
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}
 
$db_host = 'localhost';
$db_name = 'register_func';
$db_user = 'root';
$db_pass = 'vagrant';
 
// データベースへ接続する
$link = mysqli_connect( $db_host, $db_user, $db_pass, $db_name );

if ( $link !== false ) {
    $msg     = '';
    $err_msg = '';
 
    // 書き込むボタンが押された時の処理
    if ( isset( $_POST['send'] ) === true ) {

    	$user_id = $_SESSION['user'];
        $name     = $_SESSION['username'];
        $comment = $_POST['comment'];
 
        // コメントが空欄でない場合
        if ( $comment !== '' ) {

            $query = " INSERT INTO board ( "
            	   . "    user_id , "
                   . "    name , "
                   . "    comment "
                   . " ) VALUES ( "
                   . "'" . mysqli_real_escape_string( $link, $user_id ) ."', "
                   . "'" . mysqli_real_escape_string( $link, $name ) ."', "
                   . "'" . mysqli_real_escape_string( $link, $comment ) . "'"
                   ." ) ";
 
            $res   = mysqli_query( $link, $query );
            
            if ( $res !== false ) {
                $msg = '書き込みに成功しました';
            }else{
                $err_msg = '書き込みに失敗しました';
            }

        // コメントが空欄だった場合
        }else{
            $err_msg = 'コメントを記入してください';
        }
    }
 
 
    $query  = "SELECT id, user_id, name, comment FROM board";
    $res    = mysqli_query( $link,$query );
    $data = array();
    while( $row = mysqli_fetch_assoc( $res ) ) {
        array_push( $data, $row);
    }
    arsort( $data );
 
// そもそもデータベースに接続失敗してた場合
} else {
    echo "データベースの接続に失敗しました";
}
 
// データベースへの接続を閉じる
mysqli_close( $link );
?>
 
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
    	<a href="mypage.php?mypage">マイページ</a>
        <form method="post" action="">
            <!-- 名前<input type="text" name="name" value="" /> -->
            コメント<textarea name="comment" rows="4" cols="20"></textarea>
           <input type="submit" name="send" value="書き込む" />
        </form>
        <!-- ここに、書き込まれたデータを表示する -->
<?php
    if ( $msg     !== '' ) echo '<p>' . $msg . '</p>';
    if ( $err_msg !== '' ) echo '<p style="color:#f00;">' . $err_msg . '</p>';
    foreach( $data as $key => $val ){
        echo $val['name'] . ' ' . $val['comment'] . '<br>';
    }
?>
    </body>
</html>