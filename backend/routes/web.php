<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\AuthController;
use App\Models\User;


/*
Route::middleware('auth:api', 'role:admin')->get('/dashboard', function () {
    // Only users with 'admin' role can access this route
    return response()->json(['message' => 'Welcome to the Admin Dashboard']);
});

*/


Route::get('/create-default-user' , function() {
    
    $user = User::create([
        'email' => 'kenjos75@gmail.com',
        'name' => "kenneth",
        'password' => bcrypt('wanted12345')
    ]);

    $user->assignRole('job seeker');


    return response()->json([
      'user' => $user  
    ]);


});

Route::get('/create-other-users' , function() {
    
    $user = User::create([
        'email' => 'employer@gmail.com',
        'name' => "employer",
        'password' => bcrypt('wanted12345')
    ]);

    $user->assignRole('employer');

    $anotherUser = User::create([
        'email' => 'jobmoderator@gmail.com',
        'name' => "job moderator",
        'password' => bcrypt('wanted12345')
    ]);

    $anotherUser->assignRole('job board moderator');

    return response()->json([
      'status' => 'ok'  
    ]);

});






Route::get('/create-default-permission', function() {

    //general admin permission
    $dashboardPermission = Permission::create(['name' => 'dashboard permission']);

    //role for job moderator
    $role = Role::create(['name' => 'job board moderator']);
    $approveJobs = Permission::create(['name' => 'approve jobs']);
    $role->givePermissionTo($approveJobs, $dashboardPermission);


    $role = Role::create(['name' => 'employer']);
    $createJobs = Permission::create(['name' => 'create jobs']);
    $editJobs = Permission::create(['name' => 'edit jobs']);
    $deleteJobs = Permission::create(['name' => 'delete jobs']);
    $role->givePermissionTo($createJobs, $editJobs, $deleteJobs, $dashboardPermission);



    $role = Role::create(['name' => 'job seeker']);
    $seekJobs = Permission::create(['name' => 'seek jobs']);
    $role->givePermissionTo($seekJobs, $dashboardPermission); // assign permission to role

    return response()->json([
        'message' => 'permission created successfully'
    ]);
    //$user->assignRole('admin'); // assign role to user
});
