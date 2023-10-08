<?php

return [
    // Google検索は先頭32文字まで有効（らしい）
    'max_length_in_google_search' => 32,
    'end_point' => "https://www.googleapis.com/customsearch/v1",
    // @see: README.md
    'api_key' => env('API_KEY'),
    'engine_id' => env('ENGINE_ID'),
];
