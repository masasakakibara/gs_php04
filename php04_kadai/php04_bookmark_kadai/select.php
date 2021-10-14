<?php
// 0. SESSION開始！！
session_start();

// 1. ログインチェック処理！
// 以下、セッションID持ってたら、ok
// 持ってなければ、閲覧できない処理にする。
//１．関数群の読み込み
if ($_SESSION['chk_ssid'] === session_id()) {
    // ok
    // idを毎回発効する。それをSESSIONでまた共有する
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
} else {
    // id持ってない or idがおかしい
    exit("LOGIN ERROR");
}

require_once("funcs.php");
// loginCheck();

//２．データ登録SQL作成
// ！！gs_bm_tableからgs_user_table
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';

            $view .= '<a href="detail.php?id=' . $result["id"] . '">';
            $view .= h($result['書籍名']) . '/' . h($result['書籍URL']) . '/' . h($result['書籍コメント']) . '/' . h($result['登録日時']);
            $view .= '</a>';
            // 隙間をあけるコロンコロン
            $view .= '';

        // 管理者だけ削除ボタンが出る。一般人は見られない
        // もしkanri_flgがついていたら表示させる。（フラグが無ければスルーされて表示されない）
        if ( $_SESSION["kanri_flg"] ){
            $view .= '<a class="btn btn-danger" href="delete.php?id=' . $result["id"] . '">';
            $view .= '[<i class="glyphicon glyphicon-remove"></i>削除]';
            $view .= '</a>';
            
            $view .= '</p>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>好きな本のデータベース表示</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
    <!-- Main[End] -->

</body>

</html>
