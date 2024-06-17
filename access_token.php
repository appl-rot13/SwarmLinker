<?php

require_once __DIR__ . '/includes/common.php';

if (!isset($_GET['code'])) {
    http_response_code(403);
    exit;
}

$accessToken = getAccessToken($_GET['code']);
echo 'Save the access token "' . $accessToken . '" in the .env file.';
