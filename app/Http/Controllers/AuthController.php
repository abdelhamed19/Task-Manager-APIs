<?php

namespace App\Http\Controllers;

use App\Helpers\BaseResponse;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user=User::where("email",$request->email)->first();
        if (!$user)
        {
            $validated=$request->validated();
            $newuser=User::create($validated);
            $token=$newuser->createToken("api_token")->plainTextToken;
            return BaseResponse::makeResponse(["userData"=>$newuser,"token"=>$token],201,"success");
        }
        return response()->json();
    }
    public function login(Request $request)
    {
        $validated=$request->validate([
            "email"=>["required","string","email"],
            "password"=>["required","string"]
        ]);
        if (! Auth::attempt($validated))
        {
            return BaseResponse::makeResponse(null,422,"error");
        }
        $user=User::where("email",$validated['email'])->first();
        $token=$user->createToken("api_token")->plainTextToken;
        return BaseResponse::makeResponse(["userData"=>$user,"token"=>$token],200,"success");
    }
    public function logout()
    {
        $user=Auth::user();
        $user->tokens()->delete();
        return BaseResponse::makeResponse(null,200,"success");
    }
}
