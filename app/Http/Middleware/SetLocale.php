<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class SetLocale
{
    const SESSION_LOCALE_VAR ='locale-name';

    public function handle(Request $request, \Closure $next)
    {
        if(! $request->user()) {
            return $next($request);
        }

        $availableLanguages = config('user.available_locales');

        if (in_array($request->lang, $availableLanguages)) {
            $language = $request->lang;
            session()->put(static::SESSION_LOCALE_VAR, $request->lang);

        } elseif ($savedLocale = session()->get(static::SESSION_LOCALE_VAR)) {
            $language = $savedLocale;

        } else {
            $language = $request->getPreferredLanguage($availableLanguages);
        }

        if (isset($language)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
