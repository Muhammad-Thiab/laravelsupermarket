<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
class CommentController extends BaseController
{


   public function createcomment(Request $request,$id)
   {

    $validate=Validator::make($request->all(),
        [
      'comment'=>'required'
        ]);
        if($validate->fails())
        {
          return $this->sendError($validate->errors());
        }
        $product=Product::where('id',$id)->first();

        if(!$product)
        {
        return response()->json([ 'ststes'=>false,
        'message'=>' this product not found',
        'data'=>null], 401);
        }

         $comment=Comment::create([
            'costumar_id'=>$request->user()->id,
            'comment'=>$request->comment,
            'product_id'=>$id]);

         return $this->sendResponse($comment,'comment sccessfully created');
   }

   public function showcomment(Request $request,$id)
   {
       $product=Product::where('id',$id)->first();

       if(!$product)
      {
        return response()->json([ 'ststes'=>false,
        'message'=>' this product not found',
        'data'=>null], 401);
      }
      $comment= Comment::where('product_id',$id)->get();

      return $this->sendResponse($comment,'comments sccessfully fetched');
   }

}
