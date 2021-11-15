<?php

require "Coin.php";
require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => "mysql",
    'host' => "localhost",
    'database' => "ad220219_donator",
    'username' => "ad22021998",
    'password' => "zaq!@#45"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

require "Payment.php";

$coin = new CoinPaymentsAPI();
$coin->Setup("540adFb8117Bc025f749C6a4Ce6cda0F64907b8498c73dE710390154F772A7f3","30705261d36dc8472a4d225e0affaf9b420a7f436b8f72e5bbeb0f46576ad156");