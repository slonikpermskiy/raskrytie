<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckStatus
{

    public function handle($request, Closure $next){

        $response = $next($request);

        //If the status is not

        if(Auth::check() && Auth::user()->blocked == '1'){

            Auth::guard('web')->logout();

            $request->session()->flash('alert-danger', 'Your account is blocked.');
			
			$request->session()->invalidate();

			$request->session()->regenerateToken();

			$err = array();
			array_push($err, "Аккаунт заблокирован, обратитесь в службу поддержки.");
			return response()->json(['errors'=> ['error'=> $err]], 444);

        }

        return $response;

    }
	
	
	
	
	
}
