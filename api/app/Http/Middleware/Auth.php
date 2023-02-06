<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Auth
{
    public function handle(Request $request, Closure $next):  JsonResponse | Closure
    {
        $header = $request->header();
        $user_id = !$request->user ? $header['user'][0] : $request->user;
        $token = !$request->token ? $header['token'][0] : $request->token;

        if (!$user_id || !$token) {
            return $this->renderMessage("Invalid Auth Credentials");
        }

        $user = $this->checkUser($user_id);
        
        if (!$user) {
            return $this->renderMessage("User not found");
        }
        if (!$user->logged) {
            return $this->renderMessage("User not logged");
        }
        
        if (!$this->checkToken($user_id, $token)) {
            return $this->renderMessage("Token expired or invalid");
        }

        return $next($request);
    }

    protected function checkUser(int $user): bool|User
    {
        $result = User::find($user);
        if (!$result || count($result->toArray()) <= 0) {
            return false;
        }
        return $result;
    }

    protected function checkToken(int $user, string $tk)
    {
        $token = Token::where("user_id", $user)->get()->first();
        if (!$token)
            return false;
            
        if ($token->token == $tk) {
            return true;
        }
        return false;
    }

    protected function renderMessage(string|array $message)
    {
        return response()->json(["message" => $message], 404);
    }
}