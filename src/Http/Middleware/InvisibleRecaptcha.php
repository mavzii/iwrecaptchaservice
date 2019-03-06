<?php

namespace IwPackages\RecaptchaService\Http\Middleware;

use Closure;
use IwPackages\RecaptchaService\InvisibleRecaptcha as InvisibleCaptcha;

class InvisibleRecaptcha
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
        $recaptcha = new InvisibleCaptcha($request);
        $paths     = config('checkpoints.invisible.paths');

        if (!$request->ajax()) {
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
