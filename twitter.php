<link rel="stylesheet" href="style.css">
<link rel="icon" href="favicon.ico" id="favicon">
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png">

<?php

$base_url = 'https://api.twitter.com/2/tweets/search/recent'; 

if(isset($_POST['keyword'])){
    $keyword = htmlspecialchars($_POST['keyword']);
};

$query = [
    'query' => $keyword,
    'sort_order' => 'recency',
    'expansions' => 'author_id',
    'user.fields' => 'name,username',
    'max_results' => '50'
];

$url = $base_url . '?' . http_build_query($query);

$token = 'AAAAAAAAAAAAAAAAAAAAAJBujgEAAAAACkOauso%2BJOkKEXr3HeOt0qAMrMc%3DmdHX5UJShGBhd4XuVDDCCkTy4tabJvbiNhMjCiXsj2GMOKS1b9';
$header = [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
];

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

$result = json_decode($response, true);

if (($result["meta"]["result_count"]) > 0) {

curl_close($curl);

echo '<ul class="list">';

for ($i = 0; $i < count($result['includes']['users']); $i++) {
    $name = $result['includes']['users'][$i]['name'];
    $username = $result['includes']['users'][$i]['username'];
    $text = $result['data'][$i]['text'];

    echo '<li>';
    echo 'Name：' . $name . '(@' . $username . ') <br>';
    echo $text;
    echo '</li>';
    echo '<br>';

    }

echo '</ul>';  

// echo '<div class="more">';
// echo '<button> More </button>';
// echo '</div>';

} else {
    echo "No Result";
}

$link_a = 'twitter_form.html';
$link_a_text = '<< Go Back';

echo "<br/ >";
echo "<br />";
echo "<a href=" , $link_a, ">", $link_a_text, "</a>";


?>





