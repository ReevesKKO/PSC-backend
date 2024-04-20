<?php
  function jwtEncodeHS256($user_id, $account_type) {
    $secret = "REEVES";
    $alg = "HS256";
    $typ = "JWT";

    $header = json_encode(['alg' => $alg, 'typ' => $typ], JSON_UNESCAPED_UNICODE);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    $payload = json_encode(['user_id' => $user_id, 'account_type' => $account_type], JSON_UNESCAPED_UNICODE);
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    return $jwt;
  }
