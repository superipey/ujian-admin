<?php

namespace App\Services;

class Response {
    public static function success($msg = '', $data = ''){
        $return = [];
        if ($msg) $return['msg'] = $msg;
        if ($data) $return['data'] = $data;
        return response()->json($return, 200);
    }
    public static function failed($msg = 'Invalid'){
        return response()->json(['message' => $msg], 422);
    }
    public static function forbidden($msg = 'Forbidden'){
        return response()->json(['message' => $msg], 403);
    }
    public static function unauth($msg = 'Unauthorized User'){
        return response()->json(['message' => $msg], 401);
    }
}