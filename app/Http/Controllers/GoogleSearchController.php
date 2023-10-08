<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Http;

class GoogleSearchController extends Controller
{
    /**
     * テキスト検索を行う
     *
     * @param  App\Http\Requests\SearchRequest  $request
     * @return \Illuminate\View\View
     */
    public function text(SearchRequest $request)
    {
        $apiKey = config('googleSearch.api_key');
        $searchEngineId = config('googleSearch.engine_id');
        $query = mb_substr(
            $request->input('query'),
            0,
            config('googleSearch.max_length_in_google_search'),
            'UTF-8'
        );
        $language = $request->query('language', trans('search_options.lang_ja'));

        // MEMO: クエリパラメータに関しては以下を参照
        // @see: https://developers.google.com/custom-search/v1/reference/rest/v1/cse/list?hl=ja
        $response = Http::get(config('googleSearch.end_point'), [
            'key' => $apiKey,
            'cx' => $searchEngineId,
            'q' => $query,
            'lr' => $language,
        ]);

        $results = $response->json();
        $results['query'] = $query;
        // snippetキーが存在しない結果を除外
        if (isset($results['items'])) {
            $filteredItems = array_filter($results['items'], function ($item) {
                return isset($item['snippet']);
            });
            $results['items'] = array_values($filteredItems);
        }
        return view('googleSearch', compact('results'));
    }
}
