<?php

namespace App\Http\Controllers\Api;

use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\Product;
use App\Models\Costumar;
use App\Models\Like;
use App\Http\Controllers\Api\BaseController;
use App\Models\Category;
use Carbon\Carbon;
use date;
use Illuminate\Auth\Events\Validated;
use PhpParser\Node\Stmt\Catch_;

class ProductController extends BaseController
{   // خلق منتج جديد
    public function createProduct(Request $request)
    {
      // validation
      $validator = Validator::make($request->all(),[
        'name'=>'required',
        'expiry_date'=>'required|date',
        'photo'=>'required|image',
        'quantity'=>'required',
        'price'=>'required',
       'social'=>'required',
      ]);
        if($validator->fails()){
        return $this->sendError('Please validate error',$validator->errors);
       }
      if($request->expiry_date < today())
      {
          return $this->sendError('invalid expiry date');
      }
      $photo=$request->photo;
      $newphoto=time().$photo->getClientOriginalName();
      $photo->move(public_path('upload'),$newphoto);
      $path = "public/upload/$newphoto";
      $costumar_id = auth()->user()->id;

      $Product = new Product();
      $Product->costumar_id = $costumar_id;
      $Product->name = $request->name;
      $Product->expiry_date = $request->expiry_date;
      $Product->photo=$request->photo;
      $Product->quantity = $request->quantity;
      $Product->price = $request->price;
      $Product->social = $request->social;
      //$Product->category_id = $category_id;
      $Product->save();

      // send response
      return $this->sendResponse($Product,'the product created succeflly');
    }

     public function updateproduct(Request $request , $id)
     {
       $validate=Validator::make($request->all(),
       [
         'name'=>'required',
         'quantity'=>'required',
         'price'=>'required',
         'social'=>'required',
       ]);
       if($validate->fails())
       {
         return $this->sendError($validate->errors());
       }

       $product =Product::where('id',$id)->where('costumar_id',$request->user()->id)->first();
       if($product)
       {
         $product->update([
          'name'=>$request->name,
          'quantity'=>$request->quantity,
          'price'=>$request->price,
          'social'=>$request->social,
         ]);
          return $this->sendResponse($product,'updated successfully');
        }
        else{
            return $this->sendError('can not updated the Product');
        }
    }

    public function listProduct(Request $request)
    {
        if($request->sortby)
        {
          $sort=$request->sortby;
          $products =Product::where('expiry_date','>',today())
          ->orderBY($sort,'desc')
          ->withCount('comment','view','like')->get();
          return $this->sendResponse($products,'successfully fetched');
        }
        $products =Product::latest()->where('expiry_date','>',today())->withCount('comment','view','like')->get();
        $products_invalid =Product::where('expiry_date','<',today());
        $products_invalid->delete();
        return $this->sendResponse($products,'successfully fetched');
    }
    public function singleProduct(Request $request,$id)
    {

      $product =Product::find($id);

      if(!$product)
      {
        return $this->sendError('product not found');
        }

      $view=View::where('product_id',$id)->where('costumar_id',$request->user()->id)->first();
     if(!$view)
     {
       View::create([
         'product_id'=>$id,
         'costumar_id'=>$request->user()->id
      ]);
     }

     $product1 =Product::where('id',$id)->withCount('comment','view','like')->with('comment')->first();
      return $this->sendResponse($product1,'successfully');
    }
    // حذف منتج
    public function deleteProduct(Request $request , $id ){
        $product= Product::find($id);
        if(!$product){
            return $this->sendError('the Product not found');
        }
        else{
        $user = Product::where('id',$id)->where('costumar_id',$request->user()->id)->first();
        if($user)
        {
         $product->delete();
         return $this->sendResponse($user,'deleted successfully');
        }
         else{
            return $this->sendError('Can not  delete the Product');
         }
        }

    }
    //////////البحث حسب الاسم
    public function searchname(Request $request , $name )
    {
      $product =Product::where('name' ,'like','%'.$name.'%')->first();
      if(!$product)
      {
        return $this->sendError('product not found');
      }
      else{
      $product1 =Product::where('name' ,'like','%'.$name.'%')->withCount('comment','view','like')->get();

      return $this->sendResponse($product1,'successfully');
      }
    }

    public function searchexpiry(Request $request ,  $data)
    {
      $product =Product::where('expiry_date','like','%'.$data.'%')->first();
      if(!$product)
      {
        return $this->sendError('product not found');
      }
      $product1 =Product::where('expiry_date','like','%'.$data.'%')->select( 'name',
      'expiry_date',
      'photo',
      'quantity',
      'price','social')->get();
      return $this->sendResponse($product1,'successfully');
    }
///////////////////////اضافة لايك
    public function likeProduct(Request $request , $id){
        {
            $product=Product::where('id',$id)->first();
            if(!$product)
            {
              return $this->sendError('product not found');
            }
            $productlike=Like::where('product_id',$id)->where('costumar_id',$request->user()->id)->first();
            if($productlike)
            {
               $productlike->delete();
               return response()->json([ 'ststes'=>true,
               'message'=>' Like successfully removed',
               ], 200);
            }
            else{
              Like::create([
                'product_id'=>$id,
                'costumar_id'=>$request->user()->id,
              ]);
              return response()->json([ 'ststes'=>true,
              'message'=>' Like successfully toggled',
              ], 200);
            }

        }
    }
}
