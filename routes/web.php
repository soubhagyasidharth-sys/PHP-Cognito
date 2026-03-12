<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/callback', function () {

    $code = request('code');

    $response = Http::asForm()->post(
        'https://ap-south-1hq2ed9iqe.auth.ap-south-1.amazoncognito.com/oauth2/token',
        [
            'grant_type' => 'authorization_code',
            'client_id' => 'r0pngth0fva0b7m5fjplei6b1',
            'code' => $code,
            'redirect_uri' => 'http://3.108.160.157/callback'
        ]
    );

    return $response->json();
});
