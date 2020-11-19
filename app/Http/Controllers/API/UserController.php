<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $Query = User::select('*');

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
            $request->validate([
                'email' => 'required|email',
            ]);
            $checkEmail  = User::where("email",$request->email)
                                ->count();

            if($checkEmail){
                return errorResp("Email sudah terpakai!",422);
            }

            $data                   = new User;
            $data->name             = $request->name;
            $data->email            = $request->email;
            $data->password         = $request->password;
            $data->role             = $request->role;
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
            $Query = User::with('posts')->find($id);

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
            $data = User::find($request->id);
            if( $data ){

                if(strtolower($data->email) != strtolower($request->email)){
                    $checkEmail  = User::where("email",$request->email)->count();
                    if($checkEmail){
                        return errorResp("Email sudah terpakai!", 422);
                    }
                }

                $data->name             = $request->name;
                $data->email            = $request->email;
                $data->password         = $request->password;
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
                if ($request->id == $request->user()->id){
                    return errorResp("Anda tidak bisa menghapus diri anda sendiri!",422);
                }

                $data = User::find($request->id);
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
