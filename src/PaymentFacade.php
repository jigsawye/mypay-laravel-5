<?php

namespace Jigsawye\Mypay;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mypay';
    }
}
