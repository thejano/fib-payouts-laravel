<?php

namespace TheJano\FibPayouts\Services;

use Illuminate\Support\Facades\Http;
use TheJano\FibPayouts\Services\AuthService;

class PayoutService
{
    protected $authService;
    protected $baseUrl;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->baseUrl = config('fib-payout.environment') === 'production'
            ? config('fib-payout.prod_url')
            : config('fib-payout.stage_url');
    }

    public function createPayout(array $data)
    {
        $response = Http::withToken($this->authService->getAccessToken())
            ->post("{$this->baseUrl}/protected/v1/payouts", $data);

        return $response->json();
    }

    public function authorizePayout(string $payoutId)
    {
        $response = Http::withToken($this->authService->getAccessToken())
            ->post("{$this->baseUrl}/protected/v1/payouts/{$payoutId}/authorize");

        return $response->json();
    }

    public function getPayoutDetails(string $payoutId)
    {
        $response = Http::withToken($this->authService->getAccessToken())
            ->get("{$this->baseUrl}/protected/v1/payouts/{$payoutId}");

        return $response->json();
    }

    /**
     * @return array|mixed|null
     */

}