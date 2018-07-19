<各ファイルの簡単な説明>
各phpファイルの役割を簡単に記述しました。急ぎで書いたのでわかりにくくて申し訳ないです。。。

config.php,dbconnect.php
=> データベースに接続するためのやつ

register.php
=> 会員登録ページ：ユーザー名とメアドとパスワードの入力受け付けて、会員情報を扱う”users”テーブルにIDを割り当てて情報を格納

index.php
=> ログインフォーム：メアドとパスワードを受け付けて”users”を参照して一致したらログインしてhome.phpへ

home.php
=> マイページへのリンク：ユーザー情報を表示・編集したり、コメントの編集削除ができるマイページ(mypage.php)へのリンク
   コメント入力フォーム：ログイン中のユーザーIDからユーザー名を取得。受け付けたコメントとユーザー名を、書き込み内容を扱う”board”テーブルに格納。
   掲示板：boardに入ってる情報を表示

mypage.php
=> パスワードの変更(arrange_prof.php)、ログアウト(logout.php)へのリンクを表示。
   ログイン中のユーザーのコメントのみを表示し、編集(updatecomment.php,update comment2.php)・削除(deletecomment)ができるように。

updatecomment.php
=> コメントの編集フォーム
updatecomment2.php
=> 実際にデータベースの値を更新する





<(特に)参考にしたサイトやコード>
・コメントの編集・削除機能
https://noumenon-th.net/programming/2016/01/20/mysql-3/
https://noumenon-th.net/programming/2016/01/20/mysql-4/

・掲示板の基本的な機能(コメント入力、表示など)
http://www.dt30.net/gachinko/?p=507

・ログイン・ログアウト機能
https://github.com/manabubannai/register_func
