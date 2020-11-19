<?php
if (! function_exists('successResp')) {
    function successResp($message="", $data="")
    {
    	$res = ['status' => true];
        if($message){
        	$res['message'] = $message;
        }
        if($data){
            $res['data'] = $data;
        }

    	return response()->json($res);
    }
}

if (! function_exists('errorResp')) {
    function errorResp($message,$code=200)
    {
    	return response()->json([
            "status"  => false,
            "message" => $message
        ], $code);
    }
}