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
        $set = 1;
        $system = new system([
            'address' => $request->address,
            'username' => $request->username,
            'password' => $request->password
        ]);
                }

        $address = $system->address ;
        $username = $system->username ;
        $password = $system->password ;

    $url =   $address.'/player_api?username='.$username.'&password='.$password ;  
    
    $response = Http::timeout(5)->get($url);

    $json = $response->json();

    if($json){
    
    if($set){
        $system -> save();
    }

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

public function login(Request $request){

    
$password = "admin123";
    if($request->username == 'admin') {
        if($request->password == $password){

            $users = system::all();
            return view('table', ['users' => $users]);


        }
        else{

            return view('login',['error' => "Please Enter Valid Credentials"  ]);

        }
    }
    else{
        return view('login',['error' => "Please Enter Valid Credentials"  ]);

    }



}

public function delete($id){
    $user = system::find($id);
    $user->delete();
    $users = system::all();
            return view('table', ['users' => $users]);
}

}
