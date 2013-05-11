<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::get('u', array(
    'as' => 'developer_list',
    'uses' => 'UserController@userList'
));

Route::get('c', array(
    'as' => 'company_list',
    'uses' => 'UserController@userList'
));

Route::get('v', array(
    'as' => 'venture_list',
    'uses' => 'UserController@userList'
));




Route::get('logout', array('as' => 'logout', 'uses' => 'UserController@logout'));

Route::get('activation', array('as' => 'userActication', 'uses' => 'UserController@activation'));

Route::get('register', array('as' => 'register', 'uses' => 'UserController@register'));
Route::post('register', array(
    'uses' => 'UserController@newUser',
    'before' => 'csrf'
));

Route::get('login', array('as' => 'login', 'uses' => 'UserController@getLogin'));
Route::post('login', array(
    'as' => 'loginAuth',
    'uses' => 'UserController@postLogin',
    'before' => 'csrf'
));

// All Route Filters here
Route::filter('auth', 'AuthFilter');
Route::filter('superuser', 'SuperUserFilter');

// FIXME: Temp
Route::get('super', function(){
    $user = Sentry::getUser();
    $group = Sentry::getGroupProvider()->findById(1);
    $user->addGroup($group);

});

Route::group(array('before' => 'auth'), function(){

    Route::get('profile', array(
        'as' => 'profile',
        'uses' => 'UserController@profile'
    ));

    Route::put('profile', array(
        'as' => 'profile_update',
        'uses' => 'UserController@updateProfile'
    ));

    Route::get('settings', array(
        'as' => 'settings',
        'uses' => 'UserController@settings'
    ));

    Route::post('settings', array(
        'as' => 'settings_update',
        'uses' => 'UserController@updateSettings'
    ));


});

Route::group(array('before' => 'auth|superuser'), function(){
    Route::get('admin/manage_users/{id?}', array(
        'as' => 'admin_manage_user',
        'uses' => 'UserController@adminIndex'
    ));

    Route::get('admin/manage_users/{id}/permission', array(
        'as' => 'permission',
        'uses' => 'UserController@adminPermission'
    ));

    Route::get('admin/groups/{id?}', array(
        'as' => 'admin_manage_group',
        'uses' => 'UserController@adminGroup'
    ));

    Route::get('admin/groups/{id}/edit', array(
        'as' => 'admin_manage_group_edit',
        'uses' => 'UserController@adminGroupEdit'
    ));

    Route::put('admin/groups/{id}/edit', array(
        'uses' => 'UserController@adminGroupUpdate'
    ));

    Route::get('admin/groups/{id}/permission', array(
        'as' => 'admin_manage_group_permission',
        'uses' => 'UserController@adminGroupPermission'
    ));

    Route::get('admin/group/{id}/users', array(
        'as' => 'admin_manage_user_in_group',
        'uses' => 'UserController@adminUserInGroup'
    ));

    Route::delete('admin/group/{id}/delete', array(
        'as' => 'admin_delete_group',
        'uses' => 'UserController@adminDeleteGroup'
    ));
});


// Users
$regex = '[A-z0-9(_)(\-)(\.)]+';
Route::get('u/{username}', 'UsersController@showUser')->where('username', $regex);
Route::get('c/{username}', 'UsersController@showCompany')->where('username', $regex);
Route::get('a/{username}', 'UsersController@showAcamedia')->where('username', $regex);
Route::resource('u', 'UsersController');
