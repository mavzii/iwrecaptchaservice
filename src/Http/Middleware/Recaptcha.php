<?php

namespace IwPackages\RecaptchaService\Http\Middleware;

use Closure;
use IwPackages\RecaptchaService\Recaptcha as Captcha;

class Recaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $recaptcha   = new Captcha($request);
        $emptyFields = false;
        $paths       = config('checkpoints.default.paths');

        foreach ($request->all() as $data) {
            if (!isset($data) || empty($data)) {
                $emptyFields = true;

                break;
            }
        }

        if (!$emptyFields) {
            if (count($paths) > 0) {
                foreach ($paths as $path) {
                    if (strpos($request->path(), $path) !== false) {
                        $redirectPath = '';

                        // Loop through segments and concat the URIs except the last
                        for($i = 0; $i < sizeof($request->segments()); $i++) {
                            if ($i != sizeof($request->segments()) - 1) {
                                $redirectPath .= '/' . $request->segments()[$i];
                            }
                        }

                        // Verify captcha
                        $verify = $recaptcha->verify();

                        if (!$verify) {
                            return redirect($redirectPath);
                        }
                    }
                }
            } else {
                abort(500);
            }
        }

        return $next($request);
    }
}
