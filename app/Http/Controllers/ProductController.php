<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Product;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.addProduct');
    }

    public function store(StorePostRequest $request)
    {
        Product::create([
            'title'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('products.index');

    }

    public function index()
    {
        $products=Product::get();
        return view('products.productsData',['products'=>$products]);
    }

    public function destroy($id)
    {
        Product::where('id',$id)->update([
            'status'=>'disable'
        ]);
        return back();
    }

    public function edit($id)
    {
        $product=Product::where('id',$id)->first();
        return view('products.editProductMenue',['product'=>$product]);
    }

    public function update(UpdatePostRequest $request, string $id)
    {

        Product::where('id',$id)->update([
            'title'=>$request->product_name,
            'price'=>$request->price,
            'inventory'=>$request->amount_available,
            'description'=>$request->explanation,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('products.index');
    }
}

