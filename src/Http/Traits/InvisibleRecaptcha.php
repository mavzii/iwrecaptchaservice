<?php

namespace IwPackages\RecaptchaService\Http\Traits;

trait InvisibleRecaptcha
{
	/**
	 * InvisibleRecaptcha constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->middleware('recaptcha.invisible');
	}
}
