<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    //is object the right return type of the function?
    public function responseHandler($result, $msg): object {
        $res = [
            'success' => true,
            'data' => $result,
            'message' => $msg
        ];

        return response()->json($res, 200);
    }

    public function errorHandler($error, $errorMsg = [], $code = 404): object {
        $res = [
            'success' => false,
            'data' => $error
        ];

        if(!empty($errorMsg)) {
            $res['data'] = $errorMsg;
        }
        return response()->json($res, $code);
    }


}
