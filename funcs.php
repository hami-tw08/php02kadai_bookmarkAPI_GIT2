<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
        //localhostの場合
        if($_SERVER["HTTP_HOST"] == 'localhost'){
           $db_name = "bookmark_db";    //データベース名
           $db_id   = "root";      //アカウント名
           $db_pw   = "";          //パスワード：MAMPの場合 root に修正
           $db_host = "localhost"; //DBホスト 
        }
        else{ //localhost以外＊＊自分で書き直してください！！＊＊
           $db_name = "******";  //データベース名
           $db_id   = "******";  //アカウント名（さくらコントロールパネルに表示されています）
           $db_pw   = "******";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
           $db_host = "******"; //例）mysql**db.ne.jp...
        }
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);//内部で受け取るものなので攻撃対策していない           
    
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
        }
    }


//SQLエラー関数：sql_error($stmt)
function sql_error($stmt) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}


//リダイレクト関数: redirect($file_name)
function redirect($file_name) {
    header("Location: ".$file_name);
    exit();
}





