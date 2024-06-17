<?php

function tweet(string $text, string $accessToken, string $accessTokenSecret): array
{
    $connection = new Abraham\TwitterOAuth\TwitterOAuth(
        $_ENV['TWITTER_API_KEY'],
        $_ENV['TWITTER_API_KEY_SECRET'],
        $accessToken,
        $accessTokenSecret);
    $connection->setDecodeJsonAsArray(true);

    $parameters = ['text' => $text];

    $connection->setApiVersion('2');
    return $connection->post('tweets', $parameters, ['jsonPayload' => true]);
}
