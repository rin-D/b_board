<?php

$dataFile = 'bbs.dat';

#エスケープ関数の作成
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

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

        $newData = $message . "\t" . $user . "\t" . $postedAt. "\n";

        $fp = fopen($dataFile, 'a');
        fwrite($fp, $newData);
        fclose($fp);
    }
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

$posts = array_reverse($posts);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>BBS</title>
</head>
<body>
    <h1>BBS</h1>
    <form>
        message: <input type="text" name="message">
        user: <input type="text" name="user">
        <input type="submit" name="投稿">
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