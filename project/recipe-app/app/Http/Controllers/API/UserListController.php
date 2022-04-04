<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\User_lists as UserListResource;
use App\Models\User_lists;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserListController extends BaseController
{
    public function index($userId) {
        $userList = User_lists::all()->where('user_id', $userId);

        return $this->responseHandler(UserListResource::collection($userList), 'User lists retrieved');
    }

    public function createList(Request $request, $id) {
        //add logic for user to only create a list with a unique name.
        $user = User::find($id);

        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',

        ]);

        if($validated->fails()) {
            return $this->errorHandler($validated->errors());
        }

        $userList = User_lists::create([
            'title' => $request['title'],
            'user_id' => $user->id
        ]);
        return $this->responseHandler(new UserListResource($userList), 'List created');
    }

    public function getList($listId) {
        $list = User_lists::find($listId);
        $recipes = User_lists::with('recipe_list')->get();
        //dd($list->title);
        $recipes = $recipes->where($list->id);
        //dd($recipes);
        //dd($list->title);

    }

    public function deleteList($id) {

        $userList = User_lists::find($id);
        if(is_null($userList)) {
            return $this->errorHandler($userList, 'List not found');
        }
        $userList->delete();

        return $this->responseHandler([], 'List deleted');
    }

}
