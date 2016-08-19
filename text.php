<?php

$url="http://tt181.me/test0975313025.php";
$head = ['token:rd1'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array("id"=>"10", "name"=>"Rain_wang")));

$pageContent = curl_exec($ch);
echo $pageContent;