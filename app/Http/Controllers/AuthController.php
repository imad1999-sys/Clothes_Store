<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function loging(Request $request, $typeOfUser)
    {
        if ($typeOfUser == "User") {
            $user = new Users();
        } else {
            $user = new Admins();
        }
        $user = Users::where('name', $request->name)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Error']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'id' => $user->id
        ];

        return response($response);
    }


    public function singing(Request $req, $typeOfUser)
    {
        if ($typeOfUser == "user") {
            $user = new Users();
        } else {
            $user = new Admins();
        }
        $this->validate($req, [
            'name' => 'required', 'email' => 'required', 'password' => 'required'
        ]);
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->save();
        return $user;
    }
}
