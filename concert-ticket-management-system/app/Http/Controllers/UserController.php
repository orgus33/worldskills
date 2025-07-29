<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Nette\Utils\Random;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $token = $request->bearerToken();
        $user = User::where('token', $token)->first();

        if ($user) {
            return response()->json(["token" => $token]);
        }

        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        $email = $validator->getValue("email");
        $password = $validator->getValue("password");

        $user = User::where("email", $email)->first();

        if (!$user) {
            return response()->json(["message" => "invalid credentials"]);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(["message" => "Password and token invalid"]);
        }

        $newToken = Str::random(60);

        $user->token = $newToken;
        $user->save();

        return response()->json(["token" => $newToken]);

    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|size:10',
            'date_of_birth' => [
                "required",
                Rule::date()->format('Y-m-d'),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()]);
        }


        $email = $request->get("email");

        $user = User::where("email", $email)->first();

        if ($user) {
            return response()->json(["message" => "email already used"]);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $newToken = Str::random(60);

        $user->token = $newToken;
        $user->save();

        return response()->json(["token" => $newToken]);

    }
}
