<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function multiUpload(Request $request) {


        $request->validate([
            'files.*' => 'required'
        ]);

        $files = $request->file('files');

        $user = Auth::user();
        $uploadedFiles = [];

        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $file->move(base_path() . "/uploads/", $fileName);
            $uploadedFiles[] = $fileName;
        }
        
        return response()->json([
            'status' => 'true',
            'files' => $uploadedFiles,
            'user' => $user
        ]);

    }


    public function register(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        if ($user) {
            return response()->json([
                'status' => 'true',
                'user' => $user,
                'access_token' => $accessToken
            ]);
        }

        dd('jayni');

    }

    public function login(Request $request) {
        if (auth()->attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response()->json([
                'status' => 'true',
                'user' => auth()->user(),
                'access_token' => $accessToken
            ]);

        }
    }


    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg'
        ]);

        $user = Auth::user();

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(base_path() . "/uploads/" , $fileName);

        return response()->json([
            'status' => 'true',
            'file' => $fileName,
            'user' => $user
        ]);
    }


}
