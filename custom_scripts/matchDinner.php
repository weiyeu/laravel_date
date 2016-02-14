<?php

// require "..\\vendor\\predis\\predis\\autoload.php";
// use Predis\Client;

// Predis\Autoloader::register();

// try {
//     $redis = new Client();
// } catch (Exception $e) {
//     die($e->getMessage());
// }
// $message = ['event' => 'App\\Events\\PushNotification', 'data' => ['token' => 'bcba6a35d181b360ed274d4d7c56a1aa60a3049b', 'message' => 'Hello from matchDinner.php']];
// $redis->set('message', 'hello');
// $redis->publish('notification-channel', json_encode($message));

// echo $redis->get('message');

$string = hash_hmac('sha256', '6|chenweiyeu@gmail.com', 'babamamamimi');
echo $string;

