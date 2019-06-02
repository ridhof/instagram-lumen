<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
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
        $data = array();
        $data[] = array(
            'id_post'=>1,
            'username'=>'ridho',
            'tanggal'=>'2 Juni 2019',
            'caption'=>'Liburan'
        );
        return response()->json(array('data'=>$data));
    }

    public function thumbnail($username){
        $data = array();
        $data[] = array(
            'id_gambar'=>1,
            'url_gambar'=>'localhost:8000/public/images/1.png'
        );
        return response()->json(array('data'=>$data));
    }

    public function postById($id){
        $gambar = array();
        $gambar[] = array(
            'id_gambar'=>1,
            'url_gambar'=>'localhost:8000/public/images/1.png'
        );
        $komentar = array();
        $komentar[] = array(
            'id_komen'=>1,
            'username'=>'ridho',
            'isi_komen'=>'keren!'
        );
        $data = array(
            'id_post'=>$id,
            'username'=>'ridho',
            'tanggal'=>'2 Juni 2019',
            'caption'=>'Liburan!',
            'jumlah_like'=>5,
            'gambar'=>$gambar,
            'komentar'=>$komentar
        );
        return response()->json(array('data'=>$data));
    }

    public function createComment(Request $request){
        $data = array(
            'status'=>1,
            'id_komen'=>1,
            'commenting_username'=>$request->commenting_username,
            'id_post'=>$request->id_post,
            'komentar'=>$request->komentar,
            'tanggal'=>'2 Juni 2019'
        );
        return response()->json(array('data'=>$data));
    }

    public function likeCertainUser($id, $username){
        $data = array(
            'id_post'=>$id,
            'liking_username'=>$username,
            'like'=>1
        );
        return response()->json(array('data'=>$data));
    }

    public function createLike(Request $request){
        $data = array(
            'status'=>1,
            'id_post'=>$request->id_post,
            'liking_username'=>$request->liking_username,
            'like'=>0
        );
        return response()->json(array('data'=>$data));
    }
}
