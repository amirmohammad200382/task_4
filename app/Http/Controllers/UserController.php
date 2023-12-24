<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function create()
    {
        return view('.users.addUser');
    }

    public function store(StorePostRequest $request)
    {

        $image = $request->image->getClientOriginalName();
        $request->image->move(public_path('image/users'), $image);

        User::create([
            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => md5($request->password),
            'address' => $request->address,
            'postalcode' => $request->postalcode,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'created_at' => date('Y-m-d H:i:s'),
            'image' => $image,

        ]);
        return redirect()->route('users.index');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        return view('users.editUser', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        User::where('id', $id)->update([
            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'postalcode' => $request->postalcode,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->update(['status' => 'disable']);
        return back();

    }

    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'first_name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            $user = User::create(['first_name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
//            return response()->json(['status' => true,
//                'message' => 'User Created Successfully',
//                'token' => $token,], 200);
            return  redirect()->route('workplace');

        } catch (\Throwable $th) {
            return response()->json(['status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                ['email' => 'required|email',
                    'password' => 'required',]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json(['status' => false,
                    'message' => 'Email & Password does not match with our record.',],
                    401);
            }
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('API TOKEN')->plainTextToken;
//            return response()->json(['status' => true,
//                'message' => 'User Logged In Successfully',
//                'token' => $token,],
//                200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }

}
