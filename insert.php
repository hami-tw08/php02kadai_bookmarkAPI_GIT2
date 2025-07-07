<?php
//エラー表示
ini_set("display_errors", 1);
include("funcs.php");

// 1. POSTデータのチェック（空・未定義などを防ぐ）,POSTデータ取得
if (
    !isset($_POST['name']) || $_POST['name'] === '' ||
    !isset($_POST['URL']) || $_POST['URL'] === '' ||
    !isset($_POST['comment']) || $_POST['comment'] === ''
) {
    exit('ParamError: 必要なデータがPOSTされていません。');
}

$name = $_POST['name'];
$URL = $_POST['URL'];
$comment = $_POST['comment'];

//2. DB接続します
// try {
//   //Password:MAMP='root',XAMPP=''
//   $pdo = new PDO('mysql:dbname=hanami979_gs_db;charset=utf8;host=mysql3108.db.sakura.ne.jp','hanami979_gs_db','yh511511u_'); //GITHUB要注意
// } catch (PDOException $e) {
//   exit('DBConnection Error:'.$e->getMessage());
// }
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(name,URL,comment,datetime)VALUES(:name, :URL, :comment, sysdate());");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':URL', $URL, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_Error::".$error[2]);
}else{
  // ✅ ここでリダイレクト！
  header("Location: select.php");
  exit();
}
?>
