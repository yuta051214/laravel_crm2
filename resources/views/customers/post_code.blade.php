@extends('layouts.main')

@section('title', '郵便番号検索場面')

@section('content')
    <h1>郵便番号検索画面</h1>

        @if (!empty($message))
            <div class="error">
                <p>{{ $message }}</p>
            </div>
        @endif

    <form action="{{ route('customers.create') }}" method="GET">
        <label for="post_code">郵便番号検索</label>
        <input type="text" name="post_code" id="post_code" placeholder="検索したい郵便番号" value="{{ old('post_code') }}">
        <input type="submit" value="検索">
    </form>
    <button onclick="location.href='{{ route('customers.index') }}'">一覧に戻る</button>
@endsection
