<?php

namespace IwPackages\RecaptchaService\Support\Facades;

use Illuminate\Support\Facades\Facade;

class InvisibleRecaptcha extends Facade
{

    /**
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return 'IwPackages\RecaptchaService\InvisibleRecaptcha';
    }
}
