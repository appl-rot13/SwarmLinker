<?php

require_once __DIR__ . '/includes/common.php';

logging($_POST);
if (!isset($_POST['secret']) || $_POST['secret'] != $_ENV['FOURSQUARE_PUSH_SECRET']) {
    http_response_code(403);
    exit;
}

if (!isset($_POST['checkin'])) {
    exit;
}

$checkin = json_decode($_POST['checkin'], true);
$text = createTweetText($checkin['id'], $_ENV['FOURSQUARE_ACCESS_TOKEN']);

$result = tweet($text, $_ENV['TWITTER_ACCESS_TOKEN'], $_ENV['TWITTER_ACCESS_TOKEN_SECRET']);
logging($result);
