<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. まずPOSTで、index.phpからデータを取得する
$name       = $_POST['name'];
$lid        = $_POST['lid'];
$lpw        = $_POST['lpw'];
$kanri_flg  = $_POST['kanri_flg'];
$life_flg   = $_POST['life_flg'];

//2. DB接続する。new PDOでSQLデータベースと接続する。おまじないなのでこのままコピペで使う。
// try&catchでエラーが起きたら、exitする
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=gs_db4_hw;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

//３．データ登録SQL作成
// 1. SQL文を用意。PDOからMySQLを操作するのがPDO
// $stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, 書籍名, 書籍URL, 書籍コメント, 登録日時)
//                         VALUES(NULL, :bookname, :url, :comment, sysdate())");

$stmt = $pdo->prepare("INSERT INTO gs_user_table(name,lid,lpw,kanri_flg,life_flg)
                        VALUES(:name,:lid,:lpw,:kanri_flg,:life_flg)");

//  2. バインド変数を用意し、変な文字があれば無効化してくれる(文字列はSTR,数字はINT)
// ：がついた文字がバインド変数
// $stmt->bindValue(':bookname',   $bookname,  PDO::PARAM_STR);
// $stmt->bindValue(':url',        $url,       PDO::PARAM_STR);
// $stmt->bindValue(':comment',    $comment,   PDO::PARAM_STR);

$stmt->bindValue(':name',       $name,  PDO::PARAM_STR);
$stmt->bindValue(':lid',        $lid,   PDO::PARAM_STR);
$stmt->bindValue(':lpw',        $lpw,   PDO::PARAM_STR);
$stmt->bindValue(':kanri_flg',  $kanri_flg, PDO::PARAM_INT);
$stmt->bindValue(':life_flg',   $life_flg,  PDO::PARAM_INT);

//  3. 実行
$status = $stmt->execute();
//４．実行のデータ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）。これも完全コピペん
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . $error[2]);
} else {
    //５．処理したあと、header関数は、Locationで、場所（index.php）へリダイレクトできる
    header('Location: index.php');

}