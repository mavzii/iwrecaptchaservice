<?php

namespace IwPackages\RecaptchaService;

use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\NoCaptcha;

class Recaptcha
{

    /**
     * reCAPTCHA secret key
     *
     * @var string
     */
    private $secret;

    /**
     * reCAPTCHA site key
     *
     * @var string
     */
    private $siteKey;

    /**
     * NoCaptcha object
     *
     * @var object
     */
    private $captcha;

    /**
     * Request object
     *
     * @var object
     */
    private $request;

    /**
     * Response
     *
     * @var boolean
     */
    private $response;

    /**
     * Recaptcha Contructor
     *
     * @return $this
     */
    public function __construct(Request $request = null)
    {
        $err             = false;
        $recaptchaConfig = null;

        if (env('NOCAPTCHA_SECRET') != null && env('NOCAPTCHA_SITEKEY') != null) {
            $this->secret  = env('NOCAPTCHA_SECRET');
            $this->siteKey = env('NOCAPTCHA_SITEKEY');

            $this->captcha = new NoCaptcha($this->secret, $this->siteKey);

            if ($request !== null) {
                $this->setRequest($request);
            }

        } else {
            throw new \Exception('NOCAPTCHA secret and/or sitekey is undefined from env');
        }
    }

    /**
     * Set the request
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request
     *
     * @return Illuminate\Http\Request
     */
    public function getRequest($request)
    {
        return $this->request;
    }

    /**
     * Verify reCAPTCHA request
     *
     * @return boolean
     *
     * @throws \Exception
     */
    public function verify()
    {
        if ($this->captcha == null) {
            throw new \Exception('NoCaptcha instance is undefined');
        }

        return $this->captcha->verifyRequest($this->request);
    }

    /**
     * Set reCAPTCHA secret key
     *
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Returns the reCAPTCHA secret key
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret != null ? $this->secret : env('NOCAPTCHA_SECRET');
    }

    /**
     * Set reCAPTCHA site key
     *
     * @param string $siteKey
     * @return $this
     */
    public function setSiteKey($siteKey)
    {
        $this->siteKey = $siteKey;

        return $this;
    }


    /**
     * Returns the reCAPTCHA site key
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->siteKey != null ? $this->siteKey : env('NOCAPTCHA_SECRET');
    }

    /**
     * New instance of Anhskohbo\NoCaptcha\NoCaptcha
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function instance()
    {
        if ($this->secret == null) {
            throw new \Exception('reCAPTCHA secret key is undefined');
        } else if ($this->siteKey == null) {
            throw new \Exception('reCAPTCHA site key is undefined');
        }

        $this->captcha = new NoCaptcha($this->secret, $this->siteKey);

        return $this;
    }

}
