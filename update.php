<!-- //PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更 -->
<?php

//1. POSTデータ取得
$name = $_POST['name'];
$email = $_POST['email'];
$age  = $_POST['age'];
$occu = $_POST['occu'];
$address = $_POST['address'];
$content = $_POST['content'];
$id = $_POST['id'];  // hiddenで送られたidを取得する

//2. DB接続します
//*** function化する！  *****************
session_start();
require_once('funcs.php');
loginCheck();
$pdo = db_conn();

//３．データ登録SQL作成

// UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,...WHERE id = 対象ID
$stmt = $pdo->prepare('UPDATE
                        gs_an_table
                        SET
                        name = :name,email=:email,age= :age, occu=:occu,address=:address,
                        content = :content,datetime = sysdate()
                        Where id =:id;');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT); //PARAM_INTなので注意
$stmt->bindValue(':occu', $occu, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    redirect('select.php');
}

