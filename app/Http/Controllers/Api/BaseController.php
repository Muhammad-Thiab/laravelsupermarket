<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result,$message){
        $response=[
          'success'=>true,
          'data'=>$result,
          'massage'=>$message

        ];
        return response()->json($response,200);
    }
    public function sendError($error,$errormessage=[],$code=404){
        $response=[
          'success'=>false,
          'data'=>$error,


        ];
        if(!empty($errormessage)){
            $request['data']=$errormessage;
        }
        return response()->json($response,$code);
    }


    public function senderrors($massege){

        $response=[
            'massege'=>$massege
        ];
        return response()->json($massege);
    }
}
