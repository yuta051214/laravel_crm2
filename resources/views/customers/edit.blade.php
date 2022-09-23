@extends('layouts.main')

@section('title', '編集画面')

@section('content')
    <h1>編集画面</h1>
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

    {{-- <form action="/customers/{{ $customer->id }}" method="post"> --}}
    <form action="{{ route('customers.update', $customer) }}" method="post">
        @csrf
        @method('PATCH')
        <div>
            <label for="name">名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}">
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="text" name="email" id="email" value="{{ old('email', $customer->email) }}">
        </div>
        <div>
            <label for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{ old('post_code', $customer->post_code) }}">
        </div>
        <div>
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $customer->address) }}">
        </div>
        <div>
            <label for="tel">電話番号</label>
            <input type="text" name="tel" id="tel" value="{{ old('tel', $customer->tel) }}">
        </div>
        <input type="submit" value="更新">
    </form>

    <input type="hidden" id="latitude" name="latitude" value="{{ $customer->latitude }}">
    <input type="hidden" id="longitude" name="longitude" value="{{ $customer->longitude }}">
    <div id="map" style="height:50vh;"></div>

    <button onclick="location.href='{{ route('customers.index') }}'">戻る</button>
@endsection

@section('script')
    @include('partial.map')
    <script>
        const lat = document.getElementById('latitude');
        const lng = document.getElementById('longitude');
        @if (!empty($customer))
            const marker = L.marker([{{ $customer->latitude }}, {{ $customer->longitude }}], {
                    draggable: true
                })
                .bindPopup("{{ $customer->name }}", {
                    closeButton: false
                })
                .addTo(map);
            marker.on('dragend', function(e) {
                // 座標は、e.target.getLatLng()で取得
                lat.value = e.target.getLatLng()['lat'];
                lng.value = e.target.getLatLng()['lng'];
            });
        @endif
    </script>
@endsection
