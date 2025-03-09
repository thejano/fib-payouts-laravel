<?php

use TheJano\FibPayouts\Facades\FibPayout;
use Illuminate\Support\Facades\Http;
use TheJano\FibPayouts\Providers\FibPayoutsServiceProvider;


beforeEach(function () {
    $this->app->register(FibPayoutsServiceProvider::class);

    Http::fake([
        '*/auth/realms/fib-online-shop/protocol/openid-connect/token' => Http::response([
            'access_token' => 'fake_access_token',
            'expires_in' => 3600
        ], 200),

        '*/protected/v1/payouts' => Http::response([
            'payoutId' => '12345-abcde-67890'
        ], 201),

        '*/protected/v1/payouts/12345-abcde-67890/authorize' => Http::response([], 200),

        '*/protected/v1/payouts/12345-abcde-67890' => Http::response([
            'payoutId' => '12345-abcde-67890',
            'status' => 'AUTHORIZED',
            'targetAccountIban' => 'IQD123456789',
            'description' => 'Payment for services',
            'amount' => ['amount' => 1000, 'currency' => 'IQD'],
            'authorizedAt' => '2025-03-09T08:45:52.516174Z',
            'failedAt' => null
        ], 200),
    ]);
});

test('it creates a payout successfully', function () {
    $payout = FibPayout::createPayout(
        amount: 1000,
        targetAccountIban: 'IQD123456789',
        description: 'Payment for services',
    );

    expect($payout)->toHaveKey('payoutId', '12345-abcde-67890');
});

test('it authorizes a payout successfully', function () {
    $response = FibPayout::authorizePayout('12345-abcde-67890');

    expect($response)->toBe([]);
});

test('it fetches payout details', function () {
    $details = FibPayout::getPayoutDetails('12345-abcde-67890');

    expect($details)
        ->toHaveKey('payoutId', '12345-abcde-67890')
        ->toHaveKey('status', 'AUTHORIZED')
        ->toHaveKey('amount.amount', 1000)
        ->toHaveKey('amount.currency', 'IQD');
});