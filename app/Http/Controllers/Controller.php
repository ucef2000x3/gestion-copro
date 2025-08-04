<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <<<--- LIGNE N°1
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // =========================================================
    // == CETTE LIGNE EST LA PLUS IMPORTANTE ==
    // == Elle donne accès à la méthode authorize()
    // =========================================================
    use AuthorizesRequests, ValidatesRequests; // <<<--- LIGNE N°2
}
