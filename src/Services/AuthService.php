<?php

namespace TheJano\FibPayouts\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $clientId;
    protected $clientSecret;
    protected $authUrl;

    public function __construct()
    {
        $this->clientId = config('fib-payout.client_id');
        $this->clientSecret = config('fib-payout.client_secret');

        $this->authUrl = (config('fib-payout.environment') === 'production'
            ? config('fib-payout.prod_url')
            : config('fib-payout.stage_url')) . "/auth/realms/fib-online-shop/protocol/openid-connect/token";
    }

    public function getAccessToken()
    {
        $response = Http::asForm()->post($this->authUrl, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json()['access_token'] ?? null;
    }
}