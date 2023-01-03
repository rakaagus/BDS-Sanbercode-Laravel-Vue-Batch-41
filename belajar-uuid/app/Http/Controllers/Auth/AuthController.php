<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Events\UserRegisterEvent;
use App\Events\GenerateOtpUser;

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

        event(new UserRegisterEvent($user));

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
        $user = auth()->user();

        $validated = $request->validate([
            "name" => "required",
            "photo_profile" => "mimes:png,jpg,jpeg",
        ]);

        $user->name = $request->name;

        if($request->hasFile('photo_profile')){
            $photo = $request->file('photo_profile');
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = Str::slug($user->name, '-').'-'.$user->id.'.'.$photo_extension;

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

    public function generatorOTP(Request $request){
        $validated = $request->validate([
            "email" => "required|email",
        ]);

        $user = User::where('email', $request->email)->first();

        $user->generate_otp_code();

        $data['user'] = $user;

        //testing
        // Mail::to($user->email)->send(new GenerateOtp($user));
        event(new GenerateOtpUser($user));

        return response()->json([
            "success" => true,
            "message" =>  "OTP Code Berhasil di generate",
            "data" => $data,
        ], 200);
    }

    public function verifikasi(Request $request){
        $validated = $request->validate([
            "otp" => "required",
        ]);

        $otp_code = OtpCode::where('otp', $request->otp)->first();

        if(!$otp_code){
            return response()->json([
                "response_code" => "01",
                "response_message" =>  "OTP Code tidak ditemukan"
            ], 400);
        }

        $now = Carbon::now();
        if($now > $otp_code->valid_until){
            return response()->json([
                "response_code" => "01",
                "response_message" =>  "otp code sudah tidak berlaku, silahkan generate ulang"
            ], 400);
        }

        //update user ketika otp yang dimasukan benar
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        //delete otp
        $otp_code->delete();

        return response()->json([
            "response_code" => "01",
            "response_message" =>  "email sudah terverifikasi"
        ], 200);
    }
}
