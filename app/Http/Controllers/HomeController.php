<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Bioudi\LaravelMetaWeatherApi\Weather;

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
        if (Auth::user()->cities) {
            $i = 0;
            $weather = new Weather();
            $w = $weather->getByCityName(Auth::user()->cities, date('Y/m/d'));
            $we = '';
            foreach ($w as $ww) {
                if ($i == 0) {
                    $we = $ww;
                }
                $i++;
            }
            return view('home')->with('temp', $we->the_temp);
        }else{
            return view('home')->with('temp', 0);
        }
    }

    public function updateCity(Request $request)
    {

        $city = $request->cities;
        if ($city) {
            $user = User::find(Auth::user()->id);
            $user->cities = $city;
            $user->save();
        }
        return redirect('/home');
    }
}
