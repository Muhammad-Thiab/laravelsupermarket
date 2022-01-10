<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function createcategory(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);
         if($validator->fails()){
            return $this->sendError('Please validate error',$validator->errors);
        }
        $costumar_id = auth()->user()->id;
        $Product = new Category();
        $Product->name = $request->name;
        $Product->save();
        return $this->sendResponse($Product,'the product created succeflly');
    }
}
