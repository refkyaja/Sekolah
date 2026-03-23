<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\guru;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::first();
        $gurus = guru::all();
        
        return view('Home.profil', compact('profil', 'gurus'));
    }
}