<?php
//エラー表示
ini_set("display_errors", 1);


//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=hanami979_gs_db;charset=utf8;host=mysql3108.db.sakura.ne.jp','******','******'); //GITHUB要注意
  // $pdo = new PDO('mysql:dbname=bookmark_db;charset=utf8;host=localhost','root',''); 
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//2. 全データ取得
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY id DESC");
$status = $stmt->execute();

$view = "";
if ($status == false) {
  $error = $stmt->errorInfo();
  exit("SQL_Error: " . $error[2]);
} else {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= "<tr>";
    $view .= "<td>" . htmlspecialchars($row["name"], ENT_QUOTES) . "</td>";
    $view .= "<td><a href='" . htmlspecialchars($row["URL"], ENT_QUOTES) . "' target='_blank'>リンク</a></td>";
    $view .= "<td>" . htmlspecialchars($row["comment"], ENT_QUOTES) . "</td>";
    $view .= "<td>" . htmlspecialchars($row["datetime"], ENT_QUOTES) . "</td>";
    $view .="<td><a href='detail.php?id=" . $row["id"] . "'class='btn btn-primary btn-sm'>編集</a></td>";
    $view .="<td><a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('本当に削除しますか？');\" class='btn btn-danger btn-sm'>削除</a></td>";
    $view .= "</tr>";
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>登録ブックマーク一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php"></a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
     <h2>登録済みブックマーク一覧</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>書籍名</th>
        <th>URL</th>
        <th>コメント</th>
        <th>登録日時</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
    </thead>
    <tbody>
      <?= $view ?>
    </tbody>
  </table>
  </div>
</div>
<!-- Main[End] -->


<script>
  //JSON受け取り



</script>
</body>
</html>
