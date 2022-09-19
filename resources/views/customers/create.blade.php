<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>新規登録画面</h1>
    <form action="{{ route('customers.store') }}" method="post">
        @csrf
        <div>
            <label for="name">名前</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{ $post_code }}">
        </div>
        <div>
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ $address }}">
        </div>
        <div>
            <label for="tel">電話番号</label>
            <input type="text" name="tel" id="tel">
        </div>
        <input type="submit" value="登録">
    </form>
    <button onclick="location.href='/customers/post_code'">郵便番号検索に戻る</button>
</body>
</html>
