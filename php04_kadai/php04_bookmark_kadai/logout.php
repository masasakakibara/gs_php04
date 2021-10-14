<?php
// logoutはテンプレ。書き換えるところない
//必ずsession_startは最初に記述
session_start();

//SESSIONを初期化（空っぽにする）
$_SESSION = array();
// $_SESSION = []; の方がモダンな書き方

//Cookieに保存してある"SessionIDの保存期間を過去（42000秒）にして破棄
if (isset($_COOKIE[session_name()])) { //session_name()は、セッションID名を返す関数
    setcookie(session_name(), '', time() - 42000, '/');
}

//サーバ側での、セッションIDの破棄
session_destroy();

//処理後、index.phpへリダイレクト
header("Location: login.php");
exit();
