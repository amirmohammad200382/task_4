<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    public function create()
    {
        $users =User::where('status', 'enable')->get();
        $orders =Product::where('status', 'enable')->get();
        return view('orders.addOrder', ['users' => $users, 'products' => $orders]);

    }


    public function index()
    {
        $orders = Order::orderby('id')->get();
        return view('orders.ordersData', ['orders' => $orders]);
    }



    public function store(StorePostRequest $request)
    {
        $products = Product::where('status', 'enable')->get();
        foreach ($products as $product) {
            $product_name = 'product_' . $product->id;
            $total_price = ($product->price) * ($request->$product_name);
        }
        Order::Create([
            'user_id' => $request->user_id,
            'title' => $request->order_name,
            'total_price' => $total_price,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $order_id = Order::orderby('id', 'desc')->first();

        foreach ($products as $product) {
            $product_name = 'product_' . $product->id;
            if ($request->$product_name) {

                $product->orders()->save($order_id, ['count'=>$request->$product_name ,'created_at'=>date('Y-m-d H:i:s')]);
            }
        }
    }
public function destroy($id)
{
    $order=Order::where('id',$id)->first();
    $order->products()->delete();

    $order->delete();
    return back();
}




public function edit($id)
{
   $users=User::where('status','enable')->get();
 $order= Order::where('id',$id)->first();

    $products=Product::where('status','enable')->get();
    return view('orders.editOrderMenue',['users'=>$users,'order'=>$order,'products'=>$products]);
}




    public function update(UpdatePostRequest $request,$id)
    {
        $order=Order::where('id',$id)->first();
        $products=Product::where('status','enable')->get();
        $total_price=0;
        foreach ($products as $product)
        {

            $count1=$product->orders->where('id',$id)->first();

            if($count1)
                $count=$count1->pivot->count;

            else
                $count=0;
            $product_name='product_'.$product->id;
            $inventory = $product->inventory + $count - $request->$product_name ;

            $total_price+=($product->price)*($request->$product_name);

            Product::where('id', $product->id)->update([
                'inventory' => $inventory,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);



        }
        Order::where('id',$id)->update([
            'user_id'=>$request->user_id,
            'total_price'=>$total_price,
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        $order->products()->detach();

        foreach($products as $product)
        {
            $product_name='product_'.$product->id;
            if($request->$product_name)
            {

                $product->orders()->save($order,[
                    'count'=>$request->$product_name,
                    'updated_at'=>date('Y-m-d H:i:s'),
                ]);
            }
        }


        return redirect()->route('orders.index');
    }
}
