<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class GoogleSearchControllerTest extends TestCase
{
    /**
     * testメソッドの成功テスト
     */
    public function testText()
    {
        $responseLangEn = $this->get(self::makeTextSearchURL(language: 'lang_en'));
        $responseLangEn->assertStatus(200)
            ->assertViewIs('googleSearch')
            ->assertViewHas('results');

        $responseNexPage = $this->get(self::makeTextSearchURL(start: 11));
        $responseNexPage->assertStatus(200)
            ->assertViewIs('googleSearch')
            ->assertViewHas('results');
    }

    /**
     * クエリが空の場合
     */
    public function testEmptyQuery_error()
    {
        $responseNoQuery = $this->get(self::makeTextSearchURL(query: ''));
        $responseNoQuery->assertFound()
            ->assertInvalid([
                'query' => trans('Validation_error_msg.query_required')
            ]);
    }

    /**
     * API Key、検索エンジンIDが空の場合
     */
    public function testConfig_error()
    {
        Config::set('googleSearch.api_key', '');
        Config::set('googleSearch.engine_id', '');
        $responseNoQuery = $this->get(self::makeTextSearchURL());
        $responseNoQuery->assertFound()
            ->assertInvalid(
                [
                    'apiKey' => trans('Validation_error_msg.empty_api_key'),
                    'searchEngineId' => trans('Validation_error_msg.empty_engine_id'),
                ]
            );
    }

    /**
     * GoogleAPIへのリクエスト時のエラー
     */
    public function test_api_error()
    {
        Config::set('googleSearch.api_key', 'invalid_key');
        $response = $this->get(self::makeTextSearchURL());

        $response->assertStatus(200)
            ->assertSee(config('googleSearch.api_error'));
    }

    /**
     * テスト用のURL生成
     * default：/google_search?query=test&start=1&language=lang_ja
     *
     * @param string $query
     * @param integer $start
     * @param string $language
     * @return string url
     */
    private function makeTextSearchURL(
        $query = 'test',
        $start = 1,
        $language = 'lang_ja'
    ) {
        return '/google_search?query=' . urlencode($query) . '&start=' . $start . '&language=' . $language;
    }
}
