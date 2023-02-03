<?php
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(["prefix" => "auth"], function () use ($router) {
    $router->post("/register", "UserController@register");
    $router->post("/verifyUser", "AuthController@verifyUser");
    $router->post("/verifyPassword/{user}", "AuthController@verifyPassword");
});

$router->group(["middleware" => "auth"], function () use ($router) {
    $router->get("/", "TokenController@index");

    /**
     * User routes
     */
    $router->group(["prefix" => "auth"], function () use ($router) {
        $router->delete("/delete", "UserController@delete");
        $router->post("/logout", "AuthController@logout");
        $router->put("/edit", "UserController@edit");
        $router->get("/find/{user}", "UserController@find");
        $router->put("/resetPassword", "AuthController@resetPassword");
    });

    /**
     * Company routes
     */
    $router->group(["prefix" => "company"], function () use ($router) {
        $router->post("/create", "CompanyController@create");
        $router->delete("/delete", "CompanyController@delete");
        $router->get("/find/{company}", "CompanyController@find");
        $router->put("/edit", "CompanyController@edit");
    });

    /**
     * People routes
     */
    $router->group(["prefix" => "people"], function () use ($router) {
        $router->post("/create", "PeopleController@create");
        $router->delete("/delete", "PeopleController@delete");
        $router->get("/find/{peopleOrUser}", "PeopleController@find");
        $router->put("/edit", "PeopleController@edit");
    });

    /**
     * Position routes
     */
    $router->group(["prefix" => "position"], function () use ($router) {
        $router->post("/create", "UserController@create");
        $router->delete("/delete", "UserController@delete");
        $router->get("/find/{position}", "UserController@find");
        $router->put("/edit", "UserController@edit");
    }
    );
});