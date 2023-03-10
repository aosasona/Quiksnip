<link rel="stylesheet" href="/assets/css/output.css">
<?php

$s_data = $data["snip_data"];


if (!$s_data) {
    $filename = __DIR__ . "/../../assets/images/default-meta.jpg";
    header("Content-Type: image/png");
    header("Content-Length: " . filesize($filename));
    readfile($filename);
    exit;
}

if (!isset($s_data["u_username"])) $s_data["u_username"] = "guest";
$querystring = http_build_query([
    "vars" => "title:{$s_data['title']},username:{$s_data['u_username']}"
]);

$url = "https://og.wyte.space/api/v1/images/quiksnip/preview?{$querystring}";

$image = file_get_contents($url);
echo $image;

exit;
?>
