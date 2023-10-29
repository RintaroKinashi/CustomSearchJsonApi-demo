<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $start = $request->input('start', 1);

        try {
            // MEMO: クエリパラメータに関しては以下を参照
            // @see: https://developers.google.com/custom-search/v1/reference/rest/v1/cse/list?hl=ja
            $response = Http::get(config('googleSearch.end_point'), [
                'key' => $apiKey,
                'cx' => $searchEngineId,
                'q' => $query,
                'lr' => $language,
                'start' => $start,
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            self::handleApiError(config('googleSearch.api_error') . $e->getMessage());
        }

        $results = $response->json();
        $results = self::filterResultsWithSnippets($results);

        $searchOptions = trans('search_options');

        if (array_key_exists('error', $results)) {
            self::handleApiError(config('googleSearch.api_error') . $results['error']['message']);
        }

        return view('googleSearch', compact('results', 'query', 'start', 'language', 'searchOptions'));
    }

    /**
     * 画面にエラーメッセージを渡す
     *
     * @param string $errorMessage
     * @return void
     */
    private function handleApiError($errorMessage)
    {
        return view('googleSearch')->withErrors(['error' => $errorMessage]);
    }

    /**
     * snippetが存在しないアイテムを除外する
     *
     * @param array $results
     * @return array
     */
    private function filterResultsWithSnippets($results)
    {
        if (isset($results['items'])) {
            $filteredItems = array_filter($results['items'], function ($item) {
                return isset($item['snippet']);
            });
            $results['items'] = array_values($filteredItems);
        }

        return $results;
    }
}
