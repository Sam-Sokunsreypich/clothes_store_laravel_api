<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    //
    public function index(){
        $products = Products::all();
        return response()-> json($products);
    }

    public function store(Request $request){
        $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'image' => 'nullable|file|image|max:2048',
        'price' => 'required|numeric',
        'discount' => 'nullable|numeric',
        'stock' => 'required|integer',
        'store_category' => 'nullable|string',
        'user_category' => 'nullable|string',
        'after_dis_price' => 'nullable|numeric',

        ]);

        $imagePath = null;
        
        if($request -> hasFile('image')){
            $imagePath = $request->file('image')->store('products','public');
        }

        $product = Products::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'discount' => $request->discount,
        'stock' => $request->stock,
        'store_category' => $request->store_category,
        'user_category' => $request->user_category,
        'after_dis_price' => $request->after_dis_price,
        'image' => $imagePath ? '/storage/' . $imagePath : null,    
        ]);
        \Log::info('Final image path saved:', ['image' => $imagePath]);
        return response()->json([
            "message" => "Insert Product successfully!",
            "product" => $product
        ], 201);
    }
    public function find_product($id){
        $product = Products::find($id);
            if (!empty($product)){
                return response() -> json($product);
            }else{
                return response()-> json(
                    [
                        'message' => 'Product Note found!',
                        
                    ],404
            );
        };
    }
}
