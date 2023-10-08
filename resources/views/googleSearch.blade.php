
<!DOCTYPE html>
<html>
<head>
    <title>GoogleSearch</title>
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
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @elseif(isset($results))
        <h2>- 「{{ $results['query'] }}」の検索結果 -</h2>
        @if(empty($results['items']))
            <p>検索結果がありません</p>
        @else
            <ul>
                @foreach($results['items'] as $item)
                    <li>
                        <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                        <p>{{ $item['snippet'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</body>
</html>
