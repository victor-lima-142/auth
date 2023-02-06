<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function verifyUser(Request $request): JsonResponse
    {
        $user = User::where("username", $request->username)->orWhere("email", $request->email)->first();
        if (!$user)
            return response()->json([], 404);

        return response()->json(["user" => $user->id], 200);
    }

    public function verifyPassword(Request $request): JsonResponse
    {
        try {
            $user = self::checkUser($request->user);
            if (!$user)
                return response()->json([], 404);
            $check = Hash::check($request->password, $user->password);
            if (!$check)
                return response()->json(['test' => $check], 404);
            $token = Token::where("user_id", $request->user)->first();
            while (!$token)
                $token = TokenController::createToken($user);
            if (!$token)
                return response()->json(["message" => "token not created"], 500);
            $user->logged = true;
            if ($user->save())
                return response()->json(["user" => $request->user, "token" => $token->token], 200);
            return response()->json(["message" => "User couldn't be logged"], 500);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $checkRequest = self::checkRequest(["user", "password"], $request);
            if ($checkRequest !== true)
                return $checkRequest;

            $checkUser = self::checkUser($request->user);
            if (!$checkUser)
                return response()->json(["message" => "Person not found."], 404);

            $checkUser->password = Hash::make($request->password);
            $checkUser->save();
            unset($checkUser["password"]);
            return response()->json(["message" => "Company data updated.", "data" => $checkUser], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $user = User::find($request->user);
            if ($request->deleteToken) {
                if (TokenController::deleteToken($user, false)) {
                    $user->logged = false;
                    $user->save();
                    return response()->json(["message" => "User unlogged."], 200);
                }
            }
            return response()->json(["message" => "User unlogged."], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

}