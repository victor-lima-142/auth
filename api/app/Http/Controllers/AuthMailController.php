<?php

namespace App\Http\Controllers;

use App\Mail\AuthMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthMailController extends Controller
{

    public function sendValidCodePass(Request $request)
    {
        $verify = self::checkRequest(['email'], $request);
        if ($verify !== true)
            return $verify;
        Mail::to($request->email)->send(new AuthMailer(['title' => 'Testando', 'body' => 'teste aqui']));
        return response()->json(['message' => 'Código enviado. Verifique seu email.']);
    }
}