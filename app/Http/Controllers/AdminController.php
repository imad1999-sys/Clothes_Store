<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function singin(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
        ]);
        $this->validate($req, [
            'email' => 'required',
        ]);
        $this->validate($req, [
            'password' => 'required',
        ]);

        $admins = new Admins();
        $admins->name = $req->input('name');
        $admins->email = $req->input('email');
        $admins->password = Hash::make($req->input('password'));

        $admins->save();
        return $admins;
    }


    public function login(Request $request)
    {
        //  print_r($request);
        $admin = Admins::where('name', $request->name)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $admin->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $admin,
            'token' => $token,
            'id' => $admin->id
        ];

        return response($response, 201);
    }

}
