<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }
    // public function generaToken(){
    //     // genero un nuovo token per l utente
    //     $token = Str::random(80);
    //     // recupero l utente corrente
    //     $user = Auth::user();
    //     // assegno il token appena generato all utente
    //     $user->api_token = $token;
    //     // salvo a db
    //     $user->save();
    //     return redirect()->route('admin.home');
    // }


}
