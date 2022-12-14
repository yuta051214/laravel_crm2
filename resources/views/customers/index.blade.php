@extends('layouts.main')

@section('title', '顧客一覧')

@section('content')
    <h1>顧客一覧</h1>
    <table border="1">
        <tr>
            <th>顧客ID</th>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>郵便番号</th>
            <th>住所</th>
            <th>電話番号</th>
        </tr>
        @foreach ($customers as $customer)
            <tr>
                <td><a href="{{ route('customers.show', $customer) }}">{{ $customer->id }}</a></td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->post_code }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->tel }}</td>
            </tr>
        @endforeach
    </table>

    <div id="map" style="height:50vh;"></div>

    <button onclick="location.href='/customers/post_code'">新規作成</button>
@endsection

@section('script')
    @include('partial.map')
    <script>
        @if (!empty($customers))
            @foreach ($customers as $customer)
                L.marker([{{ $customer->latitude }},{{ $customer->longitude }}])
                    .bindPopup('<a href="{{ route('customers.show', $customer) }}">{{ $customer->name }}</a>', {closeButton: false})
                    .addTo(map);
            @endforeach
        @endif
    </script>
@endsection
