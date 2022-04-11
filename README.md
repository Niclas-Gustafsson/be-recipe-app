
# u06 Recipe App Backend

## Description

A RESTful API built with Laravel which should handle users and their recipe lists. The API should then be consumed by a frontend application built with Angular, to handle user login/ logout and CRUD for user lists.

## API requirements
- Same requirements as for the frontend application
- A user should be able to register an account with the API (register, login, and logout.)
- Make use of laravel’s Sanctum for authorization and authentication.
- A logged in user should be able to create lists
- The list should have a title
- The list should be able to display the recipes saved to specific lists.
- The user should be able to add lists, load lists and updating lists
- A recipe can only be uniquely added to a list, but occur in different lists.
- Recipe data should still be fetched from the external API.

## Installation

To run this project locally you need:
- Docker
- Of course an IDE and browser
- Docker extension
- Docker registry explorer (to easily attach shells, works fine with the terminal as well)

### Steps
1. Download this Github repository
2. Open the project folder be-recipe-app in your IDE
3. Inside project/recipe-app, duplicate the .env.example file and rename the duplicate .env
4. Replace the DB variables in .env to these:
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=CREATE_A_DATABASE_NAME
DB_USERNAME=root
DB_PASSWORD=
```
5. Navigate to the project folder at project/recipe-app and run the command: ```composer install``` in an integrated terminal to install all the required vendor files.
6. Attach a shell to the php image, either through the terminal or Docker Registry Explorer plugin
7. In the attached shell, navigate to the recipe-app folder with the command ```cd recipe-app```
8. Run the command: ```php artisan serve --host 0.0.0.0 --port 8000``` to start the server
9. Go to 0.0.0.0:8000 in your browser and log in with the credentials in your .env file
10. Create a new database with the name you chose for DB_DATABASE in the .env file
11. Go back to your IDE and attach a new shell to the php docker image and navigate to recipe-app (cd recipe-app)
12. Run the command: ```php artisan migrate``` to create the tables.

## API Reference

### Authentication & Authorization
A user must first register an account to be able to login for using the list feature.
It is not available for non-registred users, the search, browse, and inspect recipes however is available for everyone.

As a user logs in they'll be provided a token which is needed to first, actually be able to access
the frontend views for the "lists" route. Secondly, be able to sucessfully create, read, and delete lists.
The exact same goes for recipes. A token has to be provided in order to do these tasks.


Base URL for the deployed version: https://be-recipe-app.herokuapp.com/
Locally it's run on http://0.0.0.0:8000/ with the installation above
| Method | URI     | Action                | Middleware |
| :-------- | :------- | :------------------------- | :---------- |
| `POST` | `api/register` | App\Http\Controllers\API\AuthController@register |          |
| `POST` | `api/login` | App\Http\Controllers\API\AuthController@login |          |
| `POST` | `api/logout` | App\Http\Controllers\API\AuthController@logout | auth:sanctum |
| `GET` | `api/lists/{userId}` | App\Http\Controllers\API\UserListController@index | auth:sanctum |
| `POST` | `api/create-list/{id}` | App\Http\Controllers\API\UserListController@createList | auth:sanctum|
| `POST` | `api/list/delete/{id}` | App\Http\Controllers\API\UserListController@deleteList | auth:sanctum |
| `GET` | `api/list/{listId}` | App\Http\Controllers\API\RecipeListController@getList | auth:sanctum |
| `POST` | `api/add-recipe/{id}` | App\Http\Controllers\API\RecipeListController@addRecipe | auth:sanctum |
| `POST` | `api/remove-recipe/{id}` | App\Http\Controllers\API\RecipeListController@removeRecipe | auth:sanctum |

## URIs for user auth

| Method | URI | Parameter    | Type                      | Description |
| :-------- | :-------- | :------- | :-------------------------------- | :--------- |
| `POST`      | `api/register` | `none` | `none` | Create new user |
| `POST`      | `api/login` | `none` | `none` | Login user and create token |
| `POST`      | `api/logout` | `none` | `none` | Logout user and destroy token |

## URIs for user lists and recipes

| Method | URI | Parameter    | Type                      | Description |
| :-------- | :-------- | :------- | :-------------------------------- | :--------- |
| `GET`      | `api/lists/{userId}` | `userId` | `number` | **Required** Get all lists by user id |
| `POST`      | `api/create-list/{id}` | `id` | `number` | **Required** Create list with |
| `POST`      | `api/list/delete/{id}` | `id` | `number` | **Required** Delete list by user_list id |
| `GET`      | `api/list/{listId}` | `listId` | `number` | **Required** Get all saved recipes by user_list id |
| `POST`      | `api/add-recipe/{id}` | `id` | `number` | **Required** Create a recipe reference by user_list_id |
| `POST`      | `api/remove-recipe/{id}` | `id` | `number` | **Required** Delete recipe by id |


### Example responses

The responses are configured in the BaseController, which AuthController, UserListController, and RecipeListController all utilize for the responses.

An example call to add a recipe to a chosen UserList with id 1 would look like below
Url: http://127.0.0.1:8000/api/add-recipe/1
```
{
	"recipeName": "Supertronic Ultra Cookie",
	"recipeId": 123456,
	"image": "supertronic-cake.jpg"
}
```
Success Respons

Code: 200

```
{
	"success": true,
	"data": {
		"id": 1,
		"recipe": "Supertronic Ultra Cookie",
		"recipe_id": 123456,
		"image": "supertronic-cake.jpg",
		"user_list_id": "1",
		"created_at": "2022-04-08T14:28:40.000000Z",
		"updated_at": "2022-04-08T14:28:40.000000Z"
	},
	"message": "Recipe added"
}
```
