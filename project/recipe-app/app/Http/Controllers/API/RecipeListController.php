<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use App\Http\Resources\user_lists as UserListResource;
//use App\Http\Resources\user_lists as UserListResource;
use App\Models\Recipe_list;
//use App\Models\User_lists;
use Illuminate\Http\Request;

//use App\Http\Resources\User as UserResource;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Recipe_list as RecipeListResource;
use Validator;

class RecipeListController extends BaseController
{
    // Get all lists created by the logged in user - shouldn't be here?

    //Get specific list that user clicked and print its recipes + the list's title - shouldn't be here?
        /*public function getRecipes ($userId, $listId) {

        }*/
    public function getList($listId) {
        $recipes = Recipe_list::all()->where('user_list_id', $listId);
        $title = Recipe_list::with('user_lists')->get();
        $title = $title->where('user_list_id', $listId)->first();


        //Respond with the collection of recipes AND the title found in $title->user_lists->title
        return $this->responseHandler(RecipeListResource::collection($recipes), 'User lists retrieved');
    }

    //Add a recipe to a chosen list
    public function addRecipe($listId, Request $request) {
        $exists = Recipe_list::where('recipe',$request['recipeName'])->where('user_list_id', $listId);

        if(!$exists->count()) {

            $recipeList = Recipe_list::create([
                'recipe' => $request['recipeName'],
                'recipe_id' => $request['recipeId'],
                'image' => $request['image'],
                'user_list_id' => $listId
            ]);

        } else {
            return $this->errorHandler($exists, 'Recipe is already in this list');
        }

        return $this->responseHandler(new RecipeListResource($recipeList), 'List created');
    }
    /*public function addRecipe($recipeName,  $listId) {
        //How to handle is incorrect type is sent? configured in angular?
        $exists = Recipe_list::where('recipe',$recipeName)->where('user_list_id', $listId);

        if(!$exists->count()) {

        $recipeList = Recipe_list::create([
            'recipe' => $recipeName,
            'user_list_id' => $listId
        ]);

        } else {
            return $this->errorHandler($exists, 'Recipe is already in this list');
        }

        return $this->responseHandler(new RecipeListResource($recipeList), 'List created');
    }*/

    //Delete recipe from a selected list
    public function removeRecipe($id) {
        $recipe = Recipe_list::find($id);

        if(is_null($recipe)) {
            return $this->errorHandler($recipe, 'List not found');
        }
        $recipe->delete();

        return $this->responseHandler([], 'List deleted');

    }
}
