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
        $post = DB::table('posting')->get();
        $data = array();
        foreach($post as $row){
            $date=date_create($row->tanggal);
            $date=date_format($date,"d M Y");
            $data[] = array(
                'id_post'=>$row->idposting, //number
                'username'=>$row->username, //string
                'tanggal'=>$date, //string with format ex: 2 Juni 2019
                'caption'=>$row->komen // string
            );
        }
        return response()->json(array('data'=>$data));
    }

    public function thumbnail($username){
        $thumbnail = DB::table('gambar')
                            ->select('gambar.idposting', 'gambar.idgambar', 'gambar.extention', 'posting.username')
                            ->join('posting', 'gambar.idposting', '=', 'posting.idposting')
                            ->where('posting.username', '=', $username)
                            ->get();
        $url = "localhost:8000/images/";
        $data = array();
        $idpost_cek = array();
        foreach($thumbnail as $row){
            //check does id post of this photos already in array or not
            //data must be unique posting.id
            if(!in_array($row->idposting, $idpost_cek)){
                $idpost_cek[] = $row->idposting;
                $data[] = array(
                    'id_gambar'=>$row->idposting, //number
                    'url_gambar'=>$url.$row->idgambar.$row->extention //string url to each images
                );
            }
        }
        return response()->json(array('data'=>$data));
    }

    public function postById($id){
        $gambar = array();
        $gambar_query = DB::table('gambar')
                            ->where('gambar.idposting', '=', $id)
                            ->get();
        $url = "localhost:8000/images/";
        foreach($gambar_query as $row){
            $gambar[] = array(
                'id_gambar'=>$row->idgambar, //number
                'url_gambar'=>$url.$row->idgambar.$row->extention //string url to each images
            );
        }
        $komentar = array();
        $komentar_query = DB::table('balasan_komen')
                                ->where('balasan_komen.idposting', '=', $id)
                                ->get();
        foreach($komentar_query as $row){
            $komentar[] = array(
                'id_komen'=>$row->idbalasan_komen,
                'username'=>$row->username,
                'isi_komen'=>$row->isi_komen
            );
        }
        $post = DB::table('posting')
                        ->where('posting.idposting', '=', $id)
                        ->first();
        $date=date_create($post->tanggal);
        $date=date_format($date,"d M Y");
        $jumlah_like = DB::table('jempol_like')
                        ->where('jempol_like.idposting', '=', $id)
                        ->count();
        $data = array(
            'id_post'=>$id,
            'username'=>$post->username,
            'tanggal'=>$date,
            'caption'=>$post->komen,
            'jumlah_like'=>$jumlah_like,
            'gambar'=>$gambar,
            'komentar'=>$komentar
        );
        return response()->json(array('data'=>$data));
    }

    public function createComment(Request $request){
        DB::table('balasan_komen')->insert(
            [
                'idposting'=>$request->id_post, 
                'username'=>$request->commenting_username, 
                'isi_komen'=>$request->komentar,
                'tanggal'=>date('Y-m-d G:i:s')
            ]
        );
        $latest = DB::table('balasan_komen')
                        ->orderBy('idbalasan_komen', 'desc')
                        ->first();
        $data = array(
            'status'=>1,
            'id_komen'=>$latest->idbalasan_komen,
            'commenting_username'=>$request->commenting_username,
            'id_post'=>$request->id_post,
            'komentar'=>$request->komentar,
            'tanggal'=>date('Y-m-d G:i:s')
        );
        return response()->json(array('data'=>$data));
    }

    public function likeCertainUser($id, $username){
        $like_status = DB::table('jempol_like')
                        ->select('jempol_like.idposting', 'posting.username')
                        ->where('jempol_like.idposting', '=', $id)
                        ->where('jempol_like.username', '=', $username)
                        ->count();
        $data = array(
            'id_post'=>$id,
            'liking_username'=>$username,
            'like'=>$like_status
        );
        return response()->json(array('data'=>$data));
    }

    public function createLike(Request $request){
        $like = 1;
        if($request->like == 1){
            DB::table('jempol_like')->insert(
                [
                    'idposting'=>$request->id_post, 
                    'username'=>$request->liking_username
                ]
            );
        }
        else{
            DB::table('jempol_like')
                    ->where('idposting', '=', $request->id_post)
                    ->where('username', '=', $request->liking_username)
                    ->delete();
            $like = 0;
        }
        
        $data = array(
            'status'=>1,
            'id_post'=>$request->id_post,
            'liking_username'=>$request->liking_username,
            'like'=>$like
        );
        return response()->json(array('data'=>$data));
    }
}
