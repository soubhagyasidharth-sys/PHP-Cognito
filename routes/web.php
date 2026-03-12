<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {

    if(session('id_token')){
        return view('welcome');
    }

    return redirect('/login');
});


Route::get('/login', function () {

    $clientId = "7l4pbndvbv46r3ghlgkbi4msrt";
    $redirectUri = urlencode("https://cognito-redirect.vercel.app");

    $loginUrl = "https://ap-south-1hq2ed9iqe.auth.ap-south-1.amazoncognito.com/login".
        "?response_type=code".
        "&client_id=".$clientId.
        "&redirect_uri=".$redirectUri.
        "&scope=email+openid+phone";

    return redirect($loginUrl);
});


Route::get('/callback', function () {

    $code = request('code');

    if(!$code){
        return "Authorization code missing";
    }

    $response = Http::asForm()
        ->withBasicAuth(
            '7l4pbndvbv46r3ghlgkbi4msrt',
            '19n28gq937p9lq3370srhadt53odektom2rqjv9u70q3fg4n6ln'
        )
        ->post(
            'https://ap-south-1hq2ed9iqe.auth.ap-south-1.amazoncognito.com/oauth2/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => '7l4pbndvbv46r3ghlgkbi4msrt',
                'code' => $code,
                'redirect_uri' => 'https://cognito-redirect.vercel.app'
            ]
        );

    $tokens = $response->json();

    if(isset($tokens['access_token'])){

        session([
            'id_token' => $tokens['id_token'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token']
        ]);

        return redirect('/');
    }

    return $tokens;
});


Route::get('/logout', function(){

    session()->flush();

    return redirect('/');
});
