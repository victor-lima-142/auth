<?php

namespace App\Http\Controllers;

use App\Mail\AuthMailer;
use App\Models\CodeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthMailController extends Controller
{

    public function sendValidCodePass(Request $request)
    {
        try {
            $verify = self::checkRequest(['email'], $request);
            if ($verify !== true)
                return $verify;
            $email = $request->email;
            $user = User::where('email', '=', $email)->first();
            if (!$user)
                return response()->json(['message' => 'User not found'], 404);

            $cd = self::generateCode(6);
            $code = new CodeUser([
                'code' => $cd,
                'user_id' => $user->id
            ]);
            $code->save();

            Mail::to($request->email)->send(new AuthMailer([
                'title' => 'Testando',
                'body' => '<h5>Código de verificação: ' . $code->code . '</h5>'
            ]));
            return response()->json(['message' => 'Código enviado. Verifique seu email.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkCode(Request $request)
    {
        try {
            $verify = self::checkRequest(['email'], $request);
            if ($verify !== true)
                return $verify;
            $email = $request->email;
            $user = User::where('email', '=', $email)->first();
            if (!$user)
                return response()->json(['message' => 'user not found'], 404);

            $code = CodeUser::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->first();
            if (!$code)
                return response()->json(['message' => 'no code sent to this user', 'codes' => $code], 404);
            $result = ($code->code === $request->code);
            if ($result) {
                $codes = CodeUser::all();
                foreach ($codes as $cd) {
                    $cd->forceDelete();
                }
            }
            return response()->json(['valid' => $result, 'codes' => $code], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function resetForgotPassword(Request $request)
    {
        try {
            $verify = self::checkRequest(['email', 'newPassword'], $request);
            if ($verify !== true)
                return $verify;
            $email = $request->email;
            $user = User::where('email', '=', $email)->first();
            if (!$user)
                return response()->json(['message' => 'user not found'], 404);

            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json(['message' => 'Password updated.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    protected function generateCode(int $size = 4): string
    {
        $code = '';
        for ($i = 0; $i <= $size; $i++) {
            $number = rand(0, 9);
            $code .= strval($number);
        }
        return $code;
    }

}