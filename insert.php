<?php
  // POSTデータ取得
  $name = $_POST['name'];
  $email = $_POST['email'];
  $age  = $_POST['age'];
  $occu = $_POST['occu'];
  $address = $_POST['address'];
  $content = $_POST['content'];

  // DB接続
  try{
    $db_name = 'gs_db_kadai';
    $db_id   = 'root';
    $db_pw   = '';
    $db_host = 'localhost'; //DBホスト
    $pdo     = new PDO('mysql:dbname=' .$db_name . ';charset=utf8;host=' . $db_host, $db_id,$db_pw);
  } catch (PDOException $e){
      exit('DB Connection Error:' .$e->getMessage());
  }

  //  データ登録SQL作成
  $stmt = $pdo->prepare(
      'INSERT INTO
         gs_an_table(
         id,name,email,age,occu,address,content,datetime
         )
         VALUES(
          NULL,:name,:email,:age,:occu,:address,:content,sysdate() 
         );'
  );

  // 数値の場合 PDO::PARAM_INT
  // 文字の場合 PDO::PARAM_STR
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':age', $age, PDO::PARAM_INT); //PARAM_INTなので注意
  $stmt->bindValue(':occu', $occu, PDO::PARAM_STR);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
  $stmt->bindValue(':content', $content, PDO::PARAM_STR);
  $status = $stmt->execute(); //実行

  //４．データ登録処理後
  if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
  } else {
    //*** function化する！*****************
    header('Location: index.php');
    exit();
  }

?>