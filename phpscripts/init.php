<?php

require "Coin.php";
include('variables.php');
include('connection.php');
require "../vendor/autoload.php";

//use Illuminate\Database\Capsule\Manager as Capsule;
//
//$capsule = new Capsule;
//
//$capsule->addConnection([
//    'driver' => "mysql",
//    'host' => "localhost",
//    'database' => "ad220219_donator",
//    'username' => "ad22021998",
//    'password' => "zaq!@#45"
//]);
//$capsule->setAsGlobal();
//$capsule->bootEloquent();
//
//require "Payment.php";

$coin = new CoinPaymentsAPI();
$coin->Setup($private_key,$public_key);