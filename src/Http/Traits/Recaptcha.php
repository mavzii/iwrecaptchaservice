<?php

namespace IwPackages\RecaptchaService\Http\Traits;

trait Recaptcha
{
    /**
     * Recaptcha constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('recaptcha');
    }
}
