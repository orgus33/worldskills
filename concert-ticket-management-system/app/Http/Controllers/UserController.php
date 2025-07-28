<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $token = $request->bearerToken();

        if (User::where('token', $token)->get()) {
            return response()->json(["token" => $token]);
        }

        $email = $request->get("email");
        $password = $request->get("password");

        $user = User::where("email", $email)->get();

        if (!$user) {
            return response()->json(["message" => "invalid credentials"]);
        }

        if (!Hash::check($password, $user->password || !$email && !$password)) {
            return response()->json(["message" => "Password and token invalid"]);
        }

        $newToken = Random::generate();

        $user->token = $newToken;
        $user->save();

        return response()->json(["token" => $newToken]);

    }

    public function register(Request $request)
    {

        Validator::make($request->all(), [
            "email" => "email|required",
            "password" => "required|min:8",
            "phone" => "required",
            "firstname" => "required",
            "lastname" => "required",
            "date_of_birth" => [
                "required",
                "date",
                "before_or_equal:" . now()->subYears(13)->format('Y-m-d')
            ]
        ])->validate();

        $email = $request->get("email");

        $user = User::where("email", $email)->first();

        if ($user) {
            return response()->json(["message" => "email already used"]);
        }

        $user = User::create($request->all());

        $newToken = Random::generate();

        $user->token = $newToken;
        $user->save();

        return response()->json(["token" => $newToken]);

    }
}
