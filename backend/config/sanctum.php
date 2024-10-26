<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Requests from the following domains / hosts will receive stateful API
    | authentication cookies. Typically, these should include your local
    | and production domains which access your API via a frontend SPA.
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | This array contains the authentication guards that will be checked when
    | Sanctum is trying to authenticate a request. If none of these guards
    | are able to authenticate the request, Sanctum will use the bearer
    | token that's present on an incoming request for authentication.
    |
    */

    'guard' => ['web'],  // Laravel web guard će biti korišćen za autentifikaciju

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | Ova vrednost kontroliše broj minuta do isteka tokena. Ako je postavljeno
    | na `null`, token neće isteći. Možete postaviti određeni broj minuta po
    | vašoj potrebi.
    |
    */

    'expiration' => 60,  // Primer gde tokeni ističu nakon 60 minuta

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Sanctum može prefiksirati nove tokene radi sigurnosti. Ovo je korisno
    | za skeniranje tokena i sprečavanje njihovog slučajnog objavljivanja.
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', 'sanctum'),  // Dodat prefiks za lakše praćenje

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | Kada autentifikujete svoju SPA aplikaciju, možete prilagoditi Sanctum
    | middleware ako je potrebno.
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],

];
