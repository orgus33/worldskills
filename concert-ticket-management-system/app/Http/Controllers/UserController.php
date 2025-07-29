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

        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => "Error validation", "error" => $validator->errors()], 401);
        }

        $email = $validator->getValue("email");
        $password = $validator->getValue("password");

        $user = User::where("email", $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(["message" => "invalid credentials"], 401);
        }

        $newToken = Str::random(64);

        $user->personalAccessToken->token = $newToken;
        $user->personalAccessToken->save();


        return response()->json(["user" => $user->makeHidden("token"), "token" => $user->token]);


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
            return response()->json(["message" => "Validation error", "error" => $validator->errors()], 422);
        }


        $email = $request->get("email");

        $user = User::where("email", $email)->first();

        if ($user) {
            return response()->json(["message" => "email already used"]);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $newToken = Str::random(64);

        $user->personalAccessToken()->updateOrCreate([], ['token' => $newToken]);
        $user->personalAccessToken->save();

        return response()->json(["user" => $user->except("personal_access_token"), "token" => $user->personalAccessToken->token], 201);

    }
}
