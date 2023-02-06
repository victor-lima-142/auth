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
    $router->post("/verifyPassword", "AuthController@verifyPassword");
    $router->post('/sendValidCodePass', 'AuthMailController@sendValidCodePass');
    $router->post('/checkCode', 'AuthMailController@checkCode');
    $router->post('/resetForgotPassword', 'AuthMailController@resetForgotPassword');
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
});