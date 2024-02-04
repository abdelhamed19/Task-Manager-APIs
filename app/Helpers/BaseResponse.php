<?php

namespace App\Helpers;

class BaseResponse
{
    public static function makeResponse($data=null,$statusCode,$message)
    {
        return response()->json([
            "data"=>$data,
            "statusCode"=>$statusCode,
            "message"=>$message
        ]);
    }
}
