<?php
header("content-type: text/html; charset=utf-8");
$mc = new Memcached();
$mc->addServer("localhost", 11211);
$cach=$mc->get("foo");

echo json_encode($cach);
