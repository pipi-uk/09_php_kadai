<?php

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */
session_start();
$id = $_GET['id'];
require_once('funcs.php');
loginCheck();

$pdo = db_conn();

//２．データ登録SQL作成
// iDが$idのデータを取得するSQLを作成

$stmt = $pdo->prepare('SELECT * FROM gs_an_table WHERE id=:id;');
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
  $error = $stmt->errorInfo();
  exit('SQLError:' . print_r($error, true));
} else {
  // 成功した場合
  $result = $stmt->fetch();
}
?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/custom.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>審査申込み</legend>
                <label>名前：<input type="text" name="name" value="<?= $result['name'] ?>"></label><br>
                <label>Email：<input type="text" name="email"value="<?= $result['email'] ?>"></label><br>
                <label>年齢：<input type="text" name="age"value="<?= $result['age'] ?>"></label><br>
                <label>職業：<input type="text" name="occu"value="<?= $result
                ['occu']?>"></label><br>
                <label>住まいエリア：<input type="text" name="address"value="<?= $result['occu']?>"></label><br>
                <label><textarea name="content" rows="4" cols="40"> <?= $result['content'] ?></textarea></label><br>
                <input type="hidden"name="id"value="<?= $result['id'] ?>">
                <input type="submit" value="更新">
            </fieldset>
        </div>
    </form>
</body>

</html>