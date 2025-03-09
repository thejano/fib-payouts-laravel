<?php

namespace TheJano\FibPayouts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getToken()
 * @method static array createPayout(array $data)
 * @method static array authorizePayout(string $payoutId)
 * @method static array getPayoutDetails(string $payoutId)
 *
 * @see \TheJano\FibPayouts\FibPayout
 */
class FibPayout extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TheJano\FibPayouts\FibPayout::class;
    }
}