<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller

{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:75',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::firstOrCreate([

            'email' => $request->email,
        ],[
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'customer',
        ]);
        $user->save();
        return response()->json([
            'message' => 'User registered successfully','user'=> $user],
            201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $token = "Bearer ".$user->createToken('api_token')->accessToken;
            return response()->json([
                'message' => 'user login successfully',
                'token' => $token,
                'user' => $user,
            ]);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function logout(Request $request)
    {
        $request->user('api')->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }


// Driver CRUD
    public function index()
    {
        $drivers = User::all();
        return response()->json(['message' => 'users listed successfully', 'users' => $drivers]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:75',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

//        $driver = User::create($request->all());
        $driver = User::firstOrCreate([

            'email' => $request->email,
        ],[
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);
        $driver->save();
        $driver->vehicle()->attach($request->vehicle_id);
        return response()->json([
            'message' => ' user created successfully','user'=>$driver],
            201);
    }
    public function show($id)
    {
        $driver = User::with('vehicle','booking.payment')->findOrFail($id);
        return response()->json(['message' => 'user listed successfully', 'user' => $driver]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:75',
            'email' => 'required',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $driver = User::findOrFail($id);
        $driver->update($request->all());
        return response()->json(['message' => 'user updated successfully', 'user' => $driver]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'user deleted successfully']);
    }
}

