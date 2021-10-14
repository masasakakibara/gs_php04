<?php
// 0. SESSION開始！！
session_start();
// selectと同じ
if ($_SESSION['chk_ssid'] == session_id()) {
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
$id = $_GET["id"]; //?id~**を受け取る
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ更新</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>[編集]</legend>
                <label>書籍名：<input type="text" name="書籍名" value="<?= h($row['書籍名']) ?>" ></label><br>
                <label>書籍URL：<input type="text" name="書籍URL" value="<?= h($row['書籍URL']) ?>"></label><br>
                <label>書籍コメント：<textarea name="書籍コメント" rows="4" cols="40"><?= h($row['書籍コメント']) ?></textarea></label><br>
                <!-- 間違っていたところ。nameとrowの中に入れる文字を英数のものを入れていた。bookname, url, commentに -->
                <!-- kanri_flgの管理者だけしか読めなくする方法がわからない。if $_SESSIONだとは思うが-->
                
                <!-- idも送るが、外部から見えないようにhiddenで送る -->         
                <input type="submit" value="送信">
                <input type="hidden" name="id" value="<?= $id ?>">

            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->


</body>

</html>
