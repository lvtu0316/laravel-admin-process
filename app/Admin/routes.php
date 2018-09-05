<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('events','EventController');
    $router->resource('event_categories', EventCategoryController::class);
    $router->get('/success_events','EventController@success_events');
    $router->get('/role/user/{q}','UserController@role_user');
    $router->resource('status','StatusController');
    $router->resource('repositories','RepositoryController');
    $router->resource('repository_categories','RepositoryCategoryController');
    $router->resource('assets','AssetsController');
    $router->resource('projects','ProjectController');
    $router->resource('equipments','EquipmentTypeController');
    $router->resource('networks','NetworkTypeController');
    $router->resource('units','CountUnitController');
    $router->resource('address','AddressController');
    $router->resource('systems','SystemTypeController');
});
