
<!DOCTYPE html>
<html>
<head>
    <title>GoogleSearch</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- 検索フォーム -->
    <div>
        <form action="{{ route('text_search') }}" method="GET">
            @csrf
            <select name="language" id="language">
                @foreach(trans('search_options') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <input
                type="text"
                name="query"
                placeholder="キーワードを入力してください"
                maxlength={{config('googleSearch.max_length_in_google_search')}}
            >
            <button type="submit">検索</button>
        </form>
    </div>
    <!-- 検索結果表示 -->
    @if($errors->any())
        <ul class="result-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @elseif(isset($results))
        <h2>- 「{{ $results['query'] }}」の検索結果 -</h2>
        @if(empty($results['items']))
            <p>検索結果がありません</p>
        @else
            <ul class="result-list">
                @foreach($results['items'] as $item)
                    <a href="{{ $item['link'] }}" class="result-link">
                        <li class="result-item">
                            <h3>{{ $item['title'] }}</h3><p>{{ $item['formattedUrl'] }}</p>
                            <p class="result-snippet">
                                {{ $item['snippet'] }}
                            </p>
                        </li>
                    </a>
                @endforeach
            </ul>
        @endif
    @endif
</body>
</html>
