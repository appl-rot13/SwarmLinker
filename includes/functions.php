<?php

function request(string $url): string
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function isZipCode(string $str): bool
{
    return preg_match('/^\d{3}-\d{4}$/', $str);
}

function logging(mixed $value): void
{
    $message = date('Y/m/d H:i:s') . "\n" . print_r($value, true) . "\n";
    file_put_contents('debug.log', $message, FILE_APPEND);
}
