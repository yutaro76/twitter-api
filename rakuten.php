<?php

$keyword = '';
$response = null;

$url = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706';

// applicationIdの 'xxxxx....' は取得したアプリIDに書き換える
$params = [
    'format' => 'json',
    'applicationId' => '1053272017500142363',
    'hits' => 30,
    'imageFlag' => 1
];

// 検索する！のボタンが押された場合の処理
if (array_key_exists('keyword', $_POST)) {
    $keyword = $_POST['keyword'];
    $response_json = execute_api($url, $params, $keyword);
    $response = json_decode($response_json);  // JSONデータをオブジェクトにする
}

// Web APIを実行する
function execute_api($url, $params, $keyword) {
    $query = http_build_query($params, "", "&");
    $search_url = $url . '?' . $query . '&keyword=' . $keyword;

    return file_get_contents($search_url);
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Web API Test</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    </head>
    <body class="mt-4">
        <div class="container">
            <h1>Web API Test</h1>

            <div class="row">
                <div class="col-6">
                    <form method="POST" action="index.php">
                        <div class="form-group">
                            <label for="keyword">検索キーワード:</label>
                            <input type="text" name="keyword" class="form-control" />
                        </div>

                        <button type="submit class"="btn btn-primary">検索する</button>
                    </form>
                </div>
            </div>

            <hr />

            <?php if ($response->hits > 0) { ?>
                <div class="row">
                    <div class="col-12">
                        <h2>&quot;<?php print htmlspecialchars($keyword, ENT_QUOTES, "UTF-8"); ?>&quot;の検索結果一覧</h2>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">画像</th>
                                    <th>商品名</th>
                                    <th>価格</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($response->Items as $item) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src='<?php print htmlspecialchars($item->Item->smallImageUrls[0]->imageUrl, ENT_QUOTES, "UTF-8"); ?>' />
                                        </td>
                                        <td>
                                            <a href="<?php print htmlspecialchars($item->Item->itemUrl, ENT_QUOTES, "UTF-8"); ?>" target="_blank">
                                                <?php print htmlspecialchars($item->Item->itemName, ENT_QUOTES, "UTF-8"); ?>
                                            </a>
                                        </td>
                                        <td>
                                            &yen;<?php print htmlspecialchars(number_format($item->Item->itemPrice), ENT_QUOTES, "UTF-8"); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <p>検索結果はありません</p>
            <?php } ?>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
    </body>
</html>