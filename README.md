## 概要

Custom Search JSON API を使用し、入力したキーワードでの Google 検索結果を一覧表示する

## コンセプト

「シンプルな検索エンジン」を目指しました。

祖母がタブレットで一般的な検索エンジンを使用する際、「押す場所が分からない」と言っていたため、リンクの有効範囲を広げるなどの工夫を行なってみました。

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/assets/66721669/8e2380fa-6dce-4d53-a109-8a3ff7e77f46

## 開発環境
バックエンドにLaravel10を使用しています
```
// 初回クローン時
git clone https://github.com/RintaroKinashi/CustomSearchJsonApi-demo.git
cd CustomSearchJsonApi-demo
make install

// ※ このタイミングでenvファイルに「API key」と「検索エンジンID」を設定してください。

// アプリ立ち上げ
php artisan serve
```

※ 「API key」と「検索エンジンID」は以下のサイトから取得してください
- [Custom Search API](https://console.cloud.google.com/apis/api/customsearch.googleapis.com/metrics?project=vital-wavelet-395800)
- [Programmable Search Engine](https://programmablesearchengine.google.com/controlpanel/create/congrats?cx=f253bcf49d8e94161)

## 実装内容

### APIリクエスト部分
以下の箇所でGoogle Custom Search APIにリクエストを送信し、検索結果を取得しています。

クエリパラメータは頻繁に参照するものと思い、MEMOでソース内にコメントを残しています。

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/blob/19aa283f5cddb85dfbed3651ce9ff139f4f8f2ac/app/Http/Controllers/GoogleSearchController.php#L29-L36

### 検索言語選択機能

検索言語を選択可能にしました。以下のファイルに追加したい言語を記述するだけで、検索言語の選択肢を追加可能です。

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/blob/19aa283f5cddb85dfbed3651ce9ff139f4f8f2ac/resources/lang/ja/search_options.php#L10-L14

### エラーハンドリング

- 検索窓が空の状態で検索ボタンを押下

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/assets/66721669/38186492-f015-4b80-8fdd-b3674014d68d

- APIキー、検索エンジンIDがenvに設定されていない場合

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/assets/66721669/449d1357-8f2e-4f78-a62b-6c69bc8c0fe9

- 検索結果が該当なしの場合

https://github.com/RintaroKinashi/CustomSearchJsonApi-demo/assets/66721669/b95cf11e-133a-4b32-b554-e2a2a6762390



