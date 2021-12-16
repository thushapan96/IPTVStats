<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\system;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Datasavedcontroller extends Controller
{
    public function store(Request $request){

        $system = system::where('address', '=', $request->address)
        ->where('username', '=', $request->username)
        ->first();

        $system = system::where('username', '=', $request->username)
        ->where('address', '=', $request->address)
        ->first();

       
    if(!$system){
        $system = system::create($request->all());
                }

        $address = $system->address ;
        $username = $system->username ;
        $password = $system->password ;

    $url =   $address.'/player_api?username='.$username.'&password='.$password ;  
    
    $response = Http::get($url);
    
    $json = $response->json();

    if($json){

    $startdate = $json['user_info']['created_at'] ;
    $startdate = Carbon::createFromTimestamp($startdate)->format('m/d/Y');

    $expiration = $json['user_info']['exp_date'] ;
    $expiration = Carbon::createFromTimestamp($expiration)->format('m/d/Y');

    $noav = $json['user_info']['max_connections'] ;
    $nocus = $json['user_info']['active_cons'] ;



    return view('welcome', ['address' => $address , 'username' => $username , 'password' => $password , 'startdate' => $startdate , 'expiration' => $expiration , 'noav' => $noav , 'nocus' => $nocus ]);
    
}

else{
    $system->delete();
    return view('welcome', ['address' => $request->address , 'username' => $request->username , 'password' => $request->password , 'error' => "Please Enter Valid Credentials"  ]);
}

                }
}
