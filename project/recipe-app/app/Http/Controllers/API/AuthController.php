<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends BaseController
{
    public function index()
    {
        $users = User::all();
        //Add an stupid comment to trigger build process

        return $this->responseHandler(UserResource::collection($users), 'Users has been recieved.');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required_with:password_confirmation|same:password_confirmation|min:8',
            'password_confirmation' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return $this->errorHandler($validator->errors());
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),

        ]);
        return $this->responseHandler(new UserResource($user), 'User created');
    }

    public function getUser($id)
    {
        $user = User::find($id);


        if (is_null($user)) {
            return $this->errorHandler('User not found');
        }

        if ($user->id !== Auth::user()->id) {
            return $this->errorHandler('Unauthorized', ['error' => 'Unauthorised']);
        } else {

            return $this->responseHandler(new UserResource($user), 'User retrieved');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $userCred = $request->only('email', 'password');

        if (Auth::attempt($userCred)) {
            $auth = Auth::user();
            $success['id'] = $auth->id;
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;

            return $this->responseHandler($success, 'User logged in.');
        } else {
            return $this->errorHandler('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json('Logged out successfully, tokens has been deleted.');
    }
}
