<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/callback', function () {

    $code = request('code');

    $response = Http::asForm()
        ->withBasicAuth('7l4pbndvbv46r3ghlgkbi4msrt', '19n28gq937p9lq3370srhadt53odektom2rqjv9u70q3fg4n6ln')
        ->post(
            'https://ap-south-1hq2ed9iqe.auth.ap-south-1.amazoncognito.com/oauth2/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => 'CLIENT_ID',
                'code' => $code,
                'redirect_uri' => 'http://3.108.160.157/callback'
            ]
        );

    return $response->json();
});
