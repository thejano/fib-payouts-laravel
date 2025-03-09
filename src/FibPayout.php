<?php

namespace TheJano\FibPayouts;

use TheJano\FibPayouts\Services\AuthService;
use TheJano\FibPayouts\Services\PayoutService;

class FibPayout
{
    private static ?FibPayout $instance = null;

    protected $authService;
    protected $payoutService;

    public function __construct()
    {
        $this->authService = app(AuthService::class);
        $this->payoutService = app(PayoutService::class);
    }

    public static function make(): FibPayout
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getToken()
    {
        return $this->authService->getAccessToken();
    }

    public function createPayout(int $amount, string $targetAccountIban, string $description = '', string $currency = 'IQD')
    {
        $data = [
            'amount' => ['amount' => $amount, 'currency' => $currency],
            'targetAccountIban' => $targetAccountIban,
            'description' => $description
        ];

        return $this->payoutService->createPayout($data);
    }


    public function authorizePayout(string $payoutId)
    {
        return $this->payoutService->authorizePayout($payoutId);
    }

    public function getPayoutDetails(string $payoutId)
    {
        return $this->payoutService->getPayoutDetails($payoutId);
    }
}