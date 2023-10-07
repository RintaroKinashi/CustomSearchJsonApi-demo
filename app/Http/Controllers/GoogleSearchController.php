<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoogleSearchController extends Controller
{
    /**
     * テキスト検索を行う
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function text(Request $request)
    {
        $apiKey = config('googleSearch.api_key');
        $searchEngineId = config('googleSearch.engine_id');
        $query = $request->input('query');

        $response = Http::get(config('googleSearch.end_point'), [
            'key' => $apiKey,
            'cx' => $searchEngineId,
            'q' => $query,
            // TODO: 複数言語の検索に対応する
            'lr' => 'lang_ja',
        ]);

        $results = $response->json();
        return view('googleSearch', compact('results'));
    }
}
