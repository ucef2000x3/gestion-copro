<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id_langue_preferee) {
            // L'utilisateur est connecté et a une langue préférée
            // On récupère le code de la langue via la relation
            $langueCode = Auth::user()->langue->code_langue;
            App::setLocale($langueCode);
        }

        return $next($request);
    }
}
