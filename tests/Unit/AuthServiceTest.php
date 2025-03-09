<?php

use TheJano\FibPayouts\Services\AuthService;
use Illuminate\Support\Facades\Http;
use TheJano\FibPayouts\Providers\FibPayoutsServiceProvider;

beforeEach(function () {
    $this->app->register(FibPayoutsServiceProvider::class);
    Http::fake([
        '*/auth/realms/fib-online-shop/protocol/openid-connect/token' => Http::response([
            'access_token' => 'fake_access_token',
            'expires_in' => 3600
        ], 200),
    ]);
});

test('it retrieves an access token and caches it', function () {

    $authService = app(AuthService::class);

    $token = $authService->getAccessToken();

    expect($token)->toBe('fake_access_token');
});