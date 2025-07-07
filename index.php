<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Search & Bookmarking </title>

<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
       div{padding: 10px;font-size:16px;} 
        td{
            border-bottom: 2px solid blue;
            border-left: 2px solid blue;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Book Search & Bookmarking</h1>
    <h2>～googleブックで検索した内容を記録・表示する習作アプリ～</h2>
    <h3>検索欄に単語等を入力すると、googlebooksAPIから検索結果を引用して一覧表示します。<br>
        書籍名をクリックすると、書籍名、URL、書籍に関する説明を記録し、一覧として表示します。<br>
        記録した内容は一覧画面で編集・削除することが可能です。（2025年7月7日 NEW!）</h3>
    <h4>※個人情報等は記録しないでください</h4>
    <div>
        <input type="text" id="key">
        <button id="send">検索</button>
    </div>
    <div>
        <table id="list">
            <tr>
                <td style="width: 400px">書籍名</td>
                <td style="width: 200px">出版社</td>
                <td style="width: 300px">画像</td>
            </tr>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        //検索ボタンをクリックしたら実行

$("#send").on("click", function () {
    const url = "https://www.googleapis.com/books/v1/volumes?q=" + $("#key").val();
    $.ajax({
        url: url,
        dataType: "json"    //jsonデータをオブジェクトに自動で変換
    }).done(function (data) {
        console.log(data);
        const len = data.items.length;
        let html = ""; // 初期化を忘れずに！

        for(let i=0; i<len; i++){
            const item = data.items[i].volumeInfo;
            html += `
                <tr>
                    <td>
                        <form method="post" action="insert.php" class="book-form">
                            <input type="hidden" name="name" value="${item.title}">
                            <input type="hidden" name="URL" value="${item.infoLink}">
                            <input type="hidden" name="comment" value="${item.description || 'No description'}">
                            <button type="submit" class="book-title">${item.title}</button>
                        </form>
                    </td>
                    <td>${item.publisher || '不明'}</td>
                    <td>
                        <a href="${item.infoLink}" target="_blank">
                            <img src="${item.imageLinks?.thumbnail || ''}">
                        </a>
                    </td>
                </tr>
            `;
        }

        $("#list").empty().hide().append(`
            <tr>
                <td style="width: 400px">書籍名</td>
                <td style="width: 200px">出版社</td>
                <td style="width: 300px">画像</td>
            </tr>
        ` + html).fadeIn(1000);        
    });
});

    </script>
</div>
</body>

</html>