<?php

namespace App\Http\Controllers;

use App\Models\People;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $checkRequest = self::checkRequest(["username", "email", "password"], $request);
            if ($checkRequest !== true) {
                return $checkRequest;
            }
            $user = User::where("username", $request->username)->orWhere("email", $request->email)->first();
            if ($user) {
                return response()->json(["message" => "User already exists", "data" => $user], 500);
            }
            $user = new User([
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "level" => !$request->level ? 0 : $request->level,
                "logged" => $request->isLogged ? true : false,
            ]);
            if ($user->save()) {
                $token = TokenController::createToken($user);
                if (!$token) {
                    $user->delete();
                    return response()->json(["message" => "Token didn't created. Try register again."], 500);
                }
            }
            return response()->json(
                [
                    "user" => $user->id,
                    "token" => $token->token,
                    "email" => $user->email,
                    "username" => $user->username
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function find(Request $request): JsonResponse
    {
        try {
            $user = self::checkUser($request->user);
            $people = self::checkPeople($request->user);
            $token = self::checkToken($request->user);
            return response()->json([
                "username" => $user->username,
                "people" => $people->id,
                "token" => $token->token,
                "user" => $user->id,
                "email" => $user->email
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $checkUser = self::checkUser($request->user);
            if (!$checkUser) {
                return response()->json(["message" => "User not found."], 404);
            }
            if ($request->isSoft) {
                $checkUser->delete();
            } else {
                $checkUser->forceDelete();
            }
            return response()->json(["message" => "User deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $checkRequest = self::checkRequest(["username", "email", "password", "level", "user"], $request);
            if ($checkRequest !== true) {
                return $checkRequest;
            }
            $checkUser = self::checkUser($request->user);
            if (!$checkUser) {
                return response()->json(["message" => "User not found."], 404);
            }

            $checkUser->update($request->except(["user", "token"]));
            $checkUser->save();
            return response()->json(["message" => "User data updated."], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }
}