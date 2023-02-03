<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Dirape\Token\Token as TokenGenerator;

class TokenController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tokens = Token::all();
        if ($tokens !== null) {
            if (count($tokens->toArray()))
                return response()->json($tokens, 200);
        }
        return response()->json(["status" => 404, "message" => "not found tokens"]);
    }

    static protected function _createToken(User $user): Token|JsonResponse
    {
        try {
            $tokenGenerator = new TokenGenerator();
            $token = new Token([
                "user_id" => $user->id
            ]);
            $token->token = $tokenGenerator->unique("tokens", "token", 180, false);
            if ($token->save()) {
                return $token;
            } else {
                return response()->json(["message" => "Token didn't save"], 500);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    static protected function _deleteToken(User $user, bool $isSoft = true): bool
    {
        try {
            $token = Token::where("user_id", $user->id)->get()->first();
            if ($token->deleted_at !== null || $isSoft) {
                $token->delete();
            } else {
                $token->forceDelete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    static public function createToken(User $user): Token|JsonResponse
    {
        return self::_createToken($user);
    }

    static public function deleteToken(User $user, bool $isSoft = true): bool
    {
        return self::_deleteToken($user);
    }
}