<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    public function loginUser(Request $request)
    {
           //validation
          $validator = Validator::make($request->all(), [
              'email' => 'required',
              'password' => 'required',
          ]);

          //if validation fails
          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()], 422);
          }

          //check and auth process
          if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
              $user = Auth::user();
              $token = $user->createToken('user login')->plainTextToken;
              dd($token);

              return response()->json([
                  'token' => $token,
                  'user'  => $user
              ], 200);
          }

          return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function LogoutUser(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message'=>'anda berhasil logout'],200);
    }
}
