<?php
//1. POSTデータ取得。POSTの受け取りは$_POST["input名"];
$bookname   = $_POST['bookname'];
$url        = $_POST['url'];
$comment    = $_POST['comment'];

//2. DB接続します
require_once("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
// $stmt = $pdo->prepare("INSERT INTO gs_an_table(name,email,age,naiyou,indate)
//                         VALUES(:name,:email,:age,:naiyou,sysdate())");
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':email', $email, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':age', $age, PDO::PARAM_INT);        //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

//３．データ登録SQL作成
// 1. SQL文を用意。PDOからMySQLを操作するのがPDO
// ！！↓これをgs_bm_tableからgs_user_tableへ変える必要！！
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, 書籍名, 書籍URL, 書籍コメント, 登録日時)
                    VALUES(NULL, :bookname, :url, :comment, sysdate())");

//  2. 受け取ったデータをバインド変数を用意し、変な文字があれば無効化してくれる。だからidとかsysdateとかは不要
// (文字列はSTR,数字はINT)
// ：がついた文字がバインド変数
$stmt->bindValue(':bookname',   $bookname,  PDO::PARAM_STR);
$stmt->bindValue(':url',        $url,       PDO::PARAM_STR);
$stmt->bindValue(':comment',    $comment,   PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    //５．処理したあと、header関数は、Locationで、場所（index.php）へリダイレクトできる
    // header('Location: index.php');
    // redirect関数もある
    redirect("index.php");
}
