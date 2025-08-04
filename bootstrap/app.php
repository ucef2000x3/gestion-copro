<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    // =========================================================
    // == CETTE LIGNE EST LA PLUS IMPORTANTE ==
    // == Elle dit à Laravel où trouver votre fichier de routes web.
    // =========================================================
        web: __DIR__.'/../routes/web.php',

        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        // Vous pouvez laisser ce tableau vide, ou y ajouter AppServiceProvider.
        // Mais la découverte automatique le trouve en général.
        // Ce qui est important est de s'assurer que le fichier est lu.
        // La plupart du temps, Laravel le découvrira automatiquement.
        // Si ce n'est pas le cas, ajoutez :
        \App\Providers\AuthServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {

        // C'est ici que nous avions ajouté notre middleware SetLocale,
        // c'est la bonne place.
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


