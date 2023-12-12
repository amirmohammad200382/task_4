<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::where('status', 'enable')->get();
        return view('users.usersData', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('.users.addUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $image = $request->image->getClientOriginalName();
        $request->image->move(public_path('image/users'), $image);


        User::create([
            'user_name'=>$request->user_name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'age'=>$request->age,
            'gender'=>$request->gender,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'password'=>md5($request->password),
            'address'=>$request->address,
            'postalcode'=>$request->postalcode,
            'country'=>$request->country,
            'province'=>$request->province,
            'city'=>$request->city,
            'created_at'=>date('Y-m-d H:i:s'),
            'image'=>$image,

        ]);
        return redirect()->route('users.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user=User::where('id',$id)->first();
        return view('users.editUser',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        User::where('id',$id)->update([
            'user_name'=>$request->user_name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'age'=>$request->age,
            'gender'=>$request->gender,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
            'postalcode'=>$request->postalcode,
            'country'=>$request->country,
            'province'=>$request->province,
            'city'=>$request->city,
            'updated_at'=>date('Y-m-d H:i:s'),

        ]);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id',$id)->update(['status'=>'disable']);
        return back();

    }
}
