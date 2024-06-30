<?php

namespace App\Services;

use App\Helpers\CURL;

class Whatsapp
{
  public static function send($target, $message)
  {
    $url = env('API_WHATSAPP_URL') . "/send";
    
    if (is_array($target)) {
      $target = implode(',', $target);
    }

    $body = [
      'target' => $target,
      'message' => $message
    ];
    
    $response = CURL::send($url, $body, [
      'Authorization: ' . env('API_WHATSAPP_TOKEN'),
      'Content-Type: application/json'
    ]);

    return $response;
  }
}