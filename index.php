<?php
// 自動載入類別
require 'vendor/autoload.php';

// 執行對應的動作
$host = '127.0.0.1';
$dbname = 'member';
$user = 'root';
$pwd = '1234';

$Controller = new Mvc\Controller\Controller($host, $dbname, $user, $pwd);
$Controller->run();