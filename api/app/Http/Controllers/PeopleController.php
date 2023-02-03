<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        try {
            $checkRequest = self::checkRequest(["name", "birthday"], $request);
            if ($checkRequest !== true)
                return $checkRequest;

            $person = new People([
                "name" => $request->name,
                "birthday" => $request->birthday,
                "position_id" => $request->position_id,
                "company_id" => $request->company_id,
                "salary" => $request->salary,
                "percent_promo" => $request->percent_promo,
            ]);
            $person->save();
            return response()->json(["data" => $person], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function find(Request $request): JsonResponse
    {
        $peopleResponse = $people = [];
        try {
            $checkRequest = self::checkRequest(["peopleOrUser"], $request);
            if ($checkRequest !== true)
                return $checkRequest;
            if (gettype($request->peopleOrUser) == "string")
                array_push($people, $request->peopleOrUser);

            foreach ($people as $people_id) {
                $resp = self::checkPeople($people_id);
                if (!$resp)
                    return response()->json(["message" => "Internal server Error: Company not found: $people_id"], 500);
                $user = self::checkUser($resp->user_id);
                unset($user['password']);
                array_push($peopleResponse, ["user" => $user->toArray(), "person" => $resp->toArray()]);
            }
            if (count($people) <= 1) {
                return response()->json($peopleResponse[0], 200);
            }
            return response()->json($peopleResponse, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }
    public function delete(Request $request): JsonResponse
    {
        $companies = [];
        try {
            $checkRequest = self::checkRequest(["company"], $request);
            if ($checkRequest !== true)
                return $checkRequest;
            if (gettype($request->company) == "string")
                array_push($companies, $request->company);

            foreach ($request->company as $comp_id) {
                $resp = $this->del($comp_id);
                if (!$resp)
                    return response()->json(["message" => "Internal server Error: Company not deleted: $comp_id"], 500);
            }

            return response()->json([
                "message" => "All selected companies were deleted.",
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $checkRequest = self::checkRequest(["person_id"], $request);
            if ($checkRequest !== true)
                return $checkRequest;

            $checkPeople = self::checkPeople($request->person_id);
            if (!$checkPeople)
                return response()->json(["message" => "Person not found."], 404);

            $checkPeople->update($request->except(["user", "token", "person_id"]));
            $checkPeople->save();
            return response()->json($checkPeople, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Internal server Error:" . $e->getMessage()], 500);
        }
    }

    

    protected function del(int $id): bool
    {
        try {
            $company = self::checkCompany($id);
            if (!$company)
                return false;

            $company->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}