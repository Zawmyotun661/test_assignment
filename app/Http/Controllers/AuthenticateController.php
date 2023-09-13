<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Validators;

class AuthenticateController extends Controller
{
    public function register (Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
   $input = $request->all();
   $input['password'] = Hash::make($input['password']);
   $user = User::create($input);

    //   $token = $user->createToken('Mytoken')->accessToken;

        return response()->json(['message' => 'Successfully added', 'status' => 200, ' data' => [

           'user' =>  $user,
        ]],200);

    }

    public function login (Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $data['token_type'] = 'Bearer';

                $data['access_token'] = $user->createToken('Mytoken')->accessToken;

                return response()->json($data, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }
    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
