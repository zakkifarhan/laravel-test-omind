<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $Query = Post::select('*')->where('id_user', $request->user()->id);

            if($request->has('key') && $request->key){
                $Query->where(function($sub) use($request) {
                    $sub->orWhere("name", "like", '%'.$request->key.'%');
                });
            }

            if($request->has('orderby') && $request->has('sort')){
                $Query->orderby($request->orderby,$request->sort);
            }

            $total = $Query->count();

            $return = [
                "rows" => $Query->get(),
                "total" => $total,
            ];

            return successResp("",$return);
        } catch (Exception $e) {
            return errorResp($e->getMessage(),422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data              = new Post;
            $data->id_user     = $request->user()->id;
            $data->title       = $request->title;
            $data->description = $request->description;
            $data->save();

            return successResp("Berhasil menyimpan data");
        } catch (Exception $e) {
            return errorResp($e->getMessage(),422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $Query = Post::find($id);

            $return = [
                "rows" => $Query,
                "total" => $Query->count(),
            ];

            return successResp("", $return);

        } catch (Exception $e) {
            return errorResp($e->getMessage(),422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $data = Post::find($request->id);
            if( $data ){
                $data->title       = $request->title;
                $data->description = $request->description;                
                $data->save();

                return successResp("Berhasil menyimpan data");
                
            }else{
                return errorResp("Data tidak ditemukan!",422);
            }
        } catch (Exception $e) {
            return errorResp($e->getMessage(),422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            if($request->has('id') && $request->id){
                $data = Post::find($request->id);
                if( $data ){
                    $data->delete();
                    return successResp("Berhasil menghapus data");
                }else{
                    return errorResp("Data tidak ditemukan!",422);
                }
            }else{
                return errorResp("Data masukan salah!",422);
            }
        } catch (Exception $e) {
            return errorResp($e->getMessage(),422);
        }
    }
}
