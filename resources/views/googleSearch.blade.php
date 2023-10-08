
<!DOCTYPE html>
<html>
<head>
    <title>GoogleSearch</title>
</head>
<body>
    <div>
        <form action="{{ route('text_search') }}" method="GET">
            @csrf
            <select name="language" id="language">
                @foreach(trans('search_options') as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="query" placeholder="キーワードを入力してください">
            <button type="submit">検索</button>
        </form>
    </div>
    @if(isset($results))
        <h2>- 「{{ $results['query'] }}」の検索結果 -</h2>
        <ul>
            @foreach($results['items'] as $item)
                <li>
                    <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                    <p>{{ $item['snippet'] }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
