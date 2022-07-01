<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(12);

        return response()->json($users);
        // return $this->sendResponse(UserResource::collection($users), 'success.');
    }
    public function indexSearch()
    {
        $users = User::all();

        return $this->sendResponse(UserResource::collection($users), 'success.');
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json(
            [
                'user'    => $user
            ],
            200
        );
    }

    public function guardRole(Request $request)
    {
        $role = Auth()->user()->role;
        if ($role === 1) {
            return response()->json($role, 200);
        };
        if ($role === 2) {
            return response()->json('Page Not Found', 404);
        };
    }
}
