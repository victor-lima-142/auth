<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\People;
use App\Models\Position;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    static protected function checkRequest(array $required_fields, Request $request)
    {
        foreach ($required_fields as $field) {
            if (!$request[$field]) {
                return response()->json(["message" => "Too many parameters in request. Field required: $field"], 404);
            }
        }

        return true;
    }

    static protected function checkUser(int $user): User|bool
    {
        $user = User::find($user);
        if (!$user)
            return false;
        return $user;
    }

    static protected function checkCompany(int $company): Company|bool
    {
        $company = Company::find($company);
        if (!$company)
            return false;
        return $company;
    }

    static protected function checkPeople(int $userOrPeople): People|bool
    {
        $people = People::where("user_id", $userOrPeople)->orWhere("id", $userOrPeople)->first();
        if (!$people)
            return false;
        return $people;
    }

    static protected function checkPosition(int $position): Position|bool
    {
        $position = People::find($position);
        if (!$position)
            return false;
        return $position;
    }
    static protected function checkToken(int $userOrToken): Token|bool
    {
        $token = Token::where("user_id", $userOrToken)->orWhere("id", $userOrToken)->first();
        if (!$token)
            return false;
        return $token;
    }

}