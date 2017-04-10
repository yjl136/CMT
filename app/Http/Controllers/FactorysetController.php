<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactorysetController extends Controller
{
    public function factoryset()
    {
        return view('userFactorySet.customizeSetting');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
                return redirect('/');
            }else{
                return $next($request);
            }
        });
    }
}
