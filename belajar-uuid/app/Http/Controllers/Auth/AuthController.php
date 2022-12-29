<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function register(Request $request){
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email|email",
            "password" => "required|confirmed|min:8",
        ]);

        $user = User::create([
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => Hash::make($request->password),
        ]);

        $data['user'] = $user;

        return response()->json([
            "response_code" => "201",
            "response_message" => "user berhasil di register",
            'data' => $data
        ], 201);
    }

    public function login(Request $request){
        $validated = $request->validate([
            "email" => "required",
            "password" => "required|min:8",
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['response_message' => 'Unauthorized'], 401);
        }

        return response()->json([
            "response_code" => "201",
            "response_message" => "user berhasil login",
            'token' => $token,
        ], 201);
    }

    public function profile(){
        $data['user'] = Auth()->user();

        return response()->json([
            "response_code" => "200",
            "response_message" => "Profile berhasil ditampilkan",
            "data" => $data
        ], 200);
    }

    public function logout(){
        auth()->logout();

        return response()->json([
            "message" => "Logout Berhasil",
        ]);
    }

    public function updatePassword(Request $request){
        $data['user'] = Auth()->user();

        $validated = $request->validate([
            "email" => "required",
            "password" => "required|confirmed|min:8",
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "response_code" => "201",
            "response_message" => "password berhasil di update",
        ], 201);
    }

    public function updateProfile(Request $request){
        $data['user'] = Auth()->user();

        $validated = $request->validate([
            "name" => "required",
            "photo_profile" => "mimes:png,jpg,jpeg",
        ]);

        $user = User::where('name', $request->name)->first();
        $user->name = $request->name;

        if($request->hasFile('photo_profile')){
            $photo = $request->file('photo_profile');
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = time().'.'.$photo_extension;

            $photo_folder = '/photos/profile/';
            $photo_location = $photo_folder.$photo_name;

            try {
                $photo->move(public_path($photo_folder), $photo_name);
                $user->photo_profile = $photo_location;
            } catch (\Throwable $th) {
                return response()->json([
                    "response_code" => "00",
                    "response_message" => $th->getMessage(),
                ], 400);
            }
        }

        $user->save();
        return response()->json([
            "response_code" => "00",
            "response_message" => "Profile berhasil diupdate",
        ], 200);

    }
}
