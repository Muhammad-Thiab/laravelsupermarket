<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CostumarController;
use App\Http\Controllers\Api\ProductController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register", [CostumarController::class, "register"]);
Route::post("login", [CostumarController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function(){

    Route::get("profile", [CostumarController::class, "profile"]);
    Route::get("logout", [CostumarController::class, "logout"]);

    Route::post("create-Product", [ProductController::class, "createProduct"]);
    Route::post("create-Category", [CategoryController::class, "createcategory"]);
    Route::get("list-Product", [ProductController::class, "listProduct"]);
    Route::get("single-Product/{id}", [ProductController::class, "singleProduct"]);
    Route::get("sorte_Product/{name}", [ProductController::class, "sort"]);
    Route::delete("delete-Product/{id}", [ProductController::class, "deleteProduct"]);
    Route::get("like-Product/{name}", [ProductController::class, "likeProduct"]);
    Route::get("search-Product-name/{name}", [ProductController::class, "searchname"]);
    Route::get("search-Product-exp/{expiry_end}", [ProductController::class, "searchexpiry"]);
    Route::post("update-Product/{id}", [ProductController::class, "updateproduct"]);
    Route::post("like-Product/{id}", [ProductController::class, "likeProduct"]);

    Route::post("Add_Comment/{id}",[CommentController::class,"createcomment"]);
    Route::get("Show_Comment/{id}",[CommentController::class,"showcomment"]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


