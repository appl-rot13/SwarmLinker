<?php

function initiateAuthorization(): void
{
    redirect(
        'https://foursquare.com/oauth2/authenticate' .
        '?client_id=' . $_ENV['FOURSQUARE_API_KEY'] .
        '&response_type=code' .
        '&redirect_uri=' . $_ENV['FOURSQUARE_REDIRECT_URI']);
}

function getAccessToken(string $code): string
{
    $response = request(
        'https://foursquare.com/oauth2/access_token' .
        '?client_id=' . $_ENV['FOURSQUARE_API_KEY'] .
        '&client_secret=' . $_ENV['FOURSQUARE_API_KEY_SECRET'] .
        '&grant_type=authorization_code' .
        '&redirect_uri=' . $_ENV['FOURSQUARE_REDIRECT_URI'] .
        '&code=' . $code);

    $array = json_decode($response, true);
    return $array['access_token'];
}

function getCheckinDetails(string $checkinId, string $accessToken): array
{
    $response = request(
        'https://api.foursquare.com/v2/checkins/' . $checkinId .
        '?v=' . $_ENV['FOURSQUARE_API_VERSION'] .
        '&oauth_token=' . $accessToken);

    return json_decode($response, true);
}

function getVenueAddress(array $formattedAddress): string
{
    $venueAddress = array_pop($formattedAddress);

    if (isZipCode($venueAddress)) {
        $venueAddress = array_pop($formattedAddress);
    }

    return $venueAddress;
}

function createTweetText(string $checkinId, string $accessToken): string
{
    $array = getCheckinDetails($checkinId, $accessToken);
    $checkin = $array['response']['checkin'];

    // Please comment out if you want to posts all check-ins.
    if (!isset($checkin['shares']['twitter']) || !$checkin['shares']['twitter']) {
        return '';
    }

    $venue = $checkin['venue'];
    $venueName = $venue['name'];
    $venueAddress = getVenueAddress($venue['location']['formattedAddress']);

    $shareUrl = $checkin['checkinShortUrl'];

    return 'I\'m at ' . $venueName . ' in ' . $venueAddress . "\n" . $shareUrl;
}
