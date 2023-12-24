<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckRequest;
use App\Http\Requests\UpdateCheckRequest;
use App\Http\Models\Order;
use App\Http\Models\Factor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Faker\Provider\pt_BR\check_digit;
use function PHPUnit\TestFixture\func;

class CheckController extends Controller
{
    public function index()
    {
        $checks = Factor::all();
        return view('checks.checksData', ['checks' => $checks]);
    }

    public function create()
    {
        $orders = Order::all();
        return view('checks.addCheck', ['orders' => $orders]);
    }

    public function store(StoreCheckRequest $request)
    {
        Factor::create([
            'title' =>$request->title,
            'order_id' => $request->order_id,
        ]);
        return redirect()->route('check.index');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $checks = Factor::find($id);
        return view('checks.editCheckMenue', ['check' => $checks]);
    }

    public function update(UpdateCheckRequest $request, string $id)
    {
        Factor::where('id', $id)->update([
            'title' =>$request->title,
        ]);
        return redirect()->route('check.index');
    }

    public function destroy($id)
    {
        $Product = Factor::find($id);
        $Product->delete();

        return back();
    }

}
