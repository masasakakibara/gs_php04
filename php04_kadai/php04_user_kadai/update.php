<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更
require_once('funcs.php');

//1. detail.phpからPOSTデータ取得
// POSTの中身をdetailで飛ばした名前にすること

// $bookname   = $_POST['書籍名'];
// $url        = $_POST['書籍URL'];
// $comment    = $_POST['書籍コメント'];
// $id         = $_POST['id'];

$name       = $_POST['name'];
$lid        = $_POST['lid'];
$lpw        = $_POST['lpw'];
$kanri_flg  = $_POST['kanri_flg'];
$life_flg   = $_POST['life_flg'];
$id         = $_POST['id'];

$pdo = db_conn();

//３．データ登録SQL作成
// データベース側の名前 = bind変数はわかりやすい名前を：につけておく

// $stmt = $pdo->prepare ("UPDATE gs_bm_table
//                     SET
//                     書籍名 = :bookname,
//                     書籍URL = :url,
//                     書籍コメント = :comment,
//                     登録日時 = sysdate()
//                     WHERE
//                     id = :id;");

$stmt = $pdo->prepare("UPDATE gs_user_table 
                       SET 
                       name = :name,
                       lid = :lid,
                       lpw = :lpw,
                       kanri_flg = :kanri_flg,
                       life_flg = :life_flg
                    -- ↑最後カンマなし

                       WHERE
                       id = :id;");


// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR

// $stmt->bindValue(':bookname',   $bookname,  PDO::PARAM_STR);
// $stmt->bindValue(':url',        $url,       PDO::PARAM_STR);
// $stmt->bindValue(':comment',    $comment,   PDO::PARAM_STR);
// $stmt->bindValue(':id',         $id,        PDO::PARAM_INT);

$stmt->bindValue(':name',       $name,      PDO::PARAM_STR);
$stmt->bindValue(':lid',        $lid,       PDO::PARAM_STR);
$stmt->bindValue(':lpw',        $lpw,       PDO::PARAM_STR);
$stmt->bindValue(':kanri_flg',  $kanri_flg, PDO::PARAM_INT);
$stmt->bindValue(':life_flg',   $life_flg,  PDO::PARAM_INT);
$stmt->bindValue(':id',         $id,        PDO::PARAM_INT);

$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}

