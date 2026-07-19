<?php
use Illuminate\Support\Facades\Http;

$cloudName = 'dmdtrqkdv';
$apiKey = '523957753761896';
$apiSecret = 'AmmT4oCVMpOm6-vY3S4Z-Ph5DKM';
$timestamp = time();
$signature = sha1('timestamp=' . $timestamp . $apiSecret);

file_put_contents('test.jpg', base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA='));

$response = Http::attach('file', file_get_contents('test.jpg'), 'test.jpg')
    ->post('https://api.cloudinary.com/v1_1/' . $cloudName . '/image/upload', [
        'api_key' => $apiKey,
        'timestamp' => $timestamp,
        'signature' => $signature,
    ]);

echo $response->body();
