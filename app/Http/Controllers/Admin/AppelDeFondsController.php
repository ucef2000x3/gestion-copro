<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AppelDeFonds;
class AppelDeFondsController extends Controller
{
    public function index()
    {
        //$appels = AppelDeFonds::with('lot.copropriete')->latest()->paginate(20);
        $appels = AppelDeFonds::with('lot.residence.copropriete')->latest()->paginate(20);
        return view('admin.appels-de-fonds.index', compact('appels'));
    }
}
