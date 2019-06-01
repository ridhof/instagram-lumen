<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $user = DB::table('user')->get();
        return $user;
    }

    public function register(Request $request){
        $salt = "md5";
        $password_hash = hash($salt, $request->password);
        DB::table('user')->insert(
            ['username' => $request->username, 'nama' => $request->nama, 'password' => $password_hash, 'salt' => $salt]
        );
        return response()->json("Sukses");
    }

    public function login(Request $request)
    {
        $user = DB::table('user')->where('username', $request->username)->first();
        if(is_null($user)){
            return response()->json("Username tidak ditemukan");
        }
        $password_hash = hash($user->salt, $request->password);
        $cek = "Password Salah";
        if($password_hash == $user->password){
            $cek = "Sukses";
        }
        return response()->json($cek);
    }

    public function cari(Request $request){
        // $query = $request->query;
        $users = DB::table('user')
                        ->where('nama', 'like', "%$request->nama%")
                        ->limit(5)
                        ->get();
        return $users;
    }
}
