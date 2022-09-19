<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post_code</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @if ($errors->any())
        <div class="error">
            <p>
                <b>{{ count($errors) }}件のエラーがあります。</b>
            </p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>郵便番号検索画面</h1>
    <form action="{{ route('customers.create') }}" method="GET">
        <label for="post_code">郵便番号検索</label>
        <input type="text" name="post_code" id="post_code" placeholder="検索したい郵便番号">
        <input type="submit" value="検索">
    </form>
    <button onclick="location.href='{{ route('customers.index') }}'">一覧に戻る</button>

</body>
</html>
