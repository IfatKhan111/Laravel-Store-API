<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        $data = [
            'status'=>200,
            'product'=>$product
        ];
        
        return response()->json($data,200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'code'=>'required|unique:products|min:5|max:8',
            'name'=>'required|max:30',
            'specification'=>'required',
        ]);

        if($validator->fails())
        {
            $data = [
                'status'=>422,
                'message'=>$validator->messages()
            ];
            return response()->json($data, 422);
        }

        else
        {
            $product = new Product;

            $product->code=$request->code;
            $product->name=$request->name;
            $product->specification=$request->specification;
            $product->type=$request->type;
            $product->price=$request->price;
            $product->count=$request->count;

            $product->save();

            $data = [
                'status'=>200,
                'message'=>'Product added successfully!'
            ];

            return response()->json($data, 200);

        }
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
        [
            'code'=>'required',
            'name'=>'required',
            'specification'=>'required',
        ]);

        if($validator->fails())
        {
            $data = [
                'status'=>422,
                'message'=>$validator->messages()
            ];
            return response()->json($data, 422);
        }

        else
        {
            $product = Product::find($id);

            $product->code=$request->code;
            $product->name=$request->name;
            $product->specification=$request->specification;
            $product->type=$request->type;
            $product->price=$request->price;
            $product->count=$request->count;
            


            $product->save();

            $data = [
                'status'=>200,
                'message'=>'Product updated successfully!'
            ];

            return response()->json($data, 200);

        }

    }

    public function delete($id)
    {
        $product= Product::find($id);

        $product->delete();

        $data = [
            'status'=>200,
            'message'=>'Product deleted successfully!'
        ];

        return response()->json($data, 200);
    }
}
